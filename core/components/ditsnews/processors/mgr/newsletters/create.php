<?php
if($doc = $modx->getObject('modResource', $scriptProperties['document'])) {

	$id_resource = (int)$scriptProperties['document'];
		
	$setting = $modx->getObject('modSystemSetting', array(
		'namespace' => 'ditsnews',
		'key' => 'chunktpl'
	));
	$chunktpl = $setting->get('value');
		
	if ( $chunktpl != '' ) {
		$chunk = $modx->getObject('modChunk', array('name' => $chunktpl));
		$message = $chunk->getContent();
		
		// get resource to placeholders
		$resource = $modx->getObject('modResource', $id_resource);
		$placeholders = $resource->toArray();
		
		// get all tvs to placeholders
		$tv_query = $modx->newQuery('modTemplateVarResource');
		$tv_query->leftJoin('modTemplateVar','modTemplateVar',array("modTemplateVar.id = tmplvarid"));
		$tv_query->where(array('contentid'=>$id_resource));
		$tv_query->select($modx->getSelectColumns('modTemplateVarResource','modTemplateVarResource','',array('id','tmplvarid','contentid','value')));
		$tv_query->select($modx->getSelectColumns('modTemplateVar','modTemplateVar','',array('name')));
		$tvars = $modx->getCollection('modTemplateVarResource',$tv_query);
        foreach ($tvars as $key => $tv) {
			$placeholders['tv.'.$tv->get('name')] = $tv->get('value');
        }
		
		// replace ditsnews placeholders
		$ditsnews_placeholders = array('firstname','lastname','fullname','company','email','unsubscribe');
		foreach ($ditsnews_placeholders as $value) {
			$message = str_replace('[[+'.$value, '&#91;&#91;+'.$value, $message);
		}
		
		$chunk = $modx->newObject('modChunk');
		$chunk->setCacheable(false);
		$chunk->setContent($message);
		$message = $chunk->process($placeholders);
		
		$modx->resource =& $resource;
		
		// get the max iterations tags are processed before processing is terminated 
		$maxIterations= (integer) $modx->getOption('parser_max_iterations', null, 10);

		// parse all cacheable tags first 
		$modx->getParser()->processElementTags('', $message, true, false, '[[', ']]', array(), $maxIterations);

		// parse all non-cacheable and remove unprocessed tags 
		$modx->getParser()->processElementTags('', $message, true, true, '[[', ']]', array(), $maxIterations);
		
	} else {
		$docUrl = preg_replace('/&amp;/', '&', $modx->makeUrl($id_resource, '', '&sending=1', 'full') );

		$context = $modx->getObject('modContext', array('key' => $doc->get('context_key')));
		$contextUrl = $context->getOption('site_url', $modx->getOption('site_url'));
		unset($context);
		
		$message = file_get_contents($docUrl);
	}
	//convert entities back to normal placeholders
	$message = str_replace('&#91;&#91;', '[[', $message); 
	$message = str_replace('&#93;&#93;', ']]', $message);
	
    //CSS inline
    $modx->getService('emogrifier', 'Emogrifier', $modx->getOption('core_path').'components/ditsnews/model/emogrifier/');
    $cssStyles = '';
    preg_match_all('|<style(.*)>(.*)</style>|isU', $message, $css);
    if( !empty($css[2]) )
    {
        foreach( $css[2] as $cssblock )
        {
            $cssStyles .= $cssblock;
        }
    }
    $modx->emogrifier->setCSS($cssStyles);
    $modx->emogrifier->setHTML($message);
    $message = $modx->emogrifier->emogrify();

    $newsletter = $modx->newObject('dnNewsletter', array(
        'title' => $scriptProperties['title'],
        'date' => time(),
        'document' => (int) $scriptProperties['document'],
        'message' => $message
    ));

    //add groups
    $sendToGroups = array();
    $groups = $modx->getCollection('dnGroup');
    if( is_array($groups) ) {
        foreach($groups as $group) {
            $id = $group->get('id');
            if( $scriptProperties['groups_'.$id] ) {
                $sendToGroups[] = $group->get('id');
            }
        }
    }

    //add attachment
    $attachment = $scriptProperties['attachment'];
    if (is_uploaded_file($attachment['tmp_name'])) {
		$filepath = $modx->getOption('assets_path').'components/ditsnews/attachments/';
		$aname = $attachment['name'];
		$tname = $attachment['tmp_name'];

		$tmp = explode('.', $aname);
		$name = $tmp[0];
		$ext = $tmp[1];

		// verify file extension
		$allowed_ext = explode(',', $modx->getOption('upload_files'));
		if (!in_array($ext, $allowed_ext)) {
			return $modx->error->failure($modx->lexicon('ditsnews.newsletters.err.wrongext'));
		}

		// clear filename by clear alias algorithm from modResource
		$options = array();
        $charset = strtoupper((string) $modx->getOption('modx_charset', $options, 'UTF-8'));
        $delimiter = $modx->getOption('friendly_alias_word_delimiter', $options, '-');
		$stripElementTags = (boolean) $modx->getOption('friendly_alias_strip_element_tags', $options, true);
		$translit = $modx->getOption('friendly_alias_translit', $options, $iconv ? 'iconv' : 'none');
		$translitClass = $modx->getOption('friendly_alias_translit_class', $options, 'translit.modTransliterate');

        $name = $modx->stripTags($name, '', $stripElementTags ? array() : null);
        $name = str_replace(' ', $delimiter, $name);
        $name = html_entity_decode($name, ENT_QUOTES, $charset);

        switch ($translit) {
            case '':
            case 'none': break;
            case 'iconv': $name = iconv($mbext ? mb_detect_encoding($name) : $charset, $charset . '//TRANSLIT//IGNORE', $tmp[0]); break;
            default:
                $translitClassPath = $modx->getOption('friendly_alias_translit_class_path', $options, $modx->getOption('core_path', $options, MODX_CORE_PATH) . 'components/');
                if ($modx->getService('translit', $translitClass, $translitClassPath, $options)) {
                    $name = $modx->translit->translate($name, $translit);
                }
            break;
        }
        $name .= '.'.$ext;

		if (file_exists($filepath.$name)) {
			return $modx->error->failure($modx->lexicon('ditsnews.newsletters.err.fexists'));
		}

		if (!is_dir($filepath)) {
			mkdir($filepath);
		}

        if (move_uploaded_file($tname, $filepath.$name)) {
			$newsletter->set('attachment', $name);
		}

	}

    // Return values
    if ($newsletter->save()) {
        if(count($sendToGroups)) {
            $c = $modx->newQuery('dnSubscriber');
            $c->leftJoin('dnGroupSubscribers', 'Groups');
            $c->where('Groups.group IN('.implode($sendToGroups, ',').')');
            $c->andCondition(array('dnSubscriber.active' => 1));
            $subscribers = $modx->getCollection('dnSubscriber' , $c);
            foreach($subscribers as $subscriber) {
                $queueItem = $modx->newObject('dnQueue');
                $queueItem->fromArray(
                    array(
                        'newsletter' => $newsletter->get('id'),
                        'subscriber' => $subscriber->get('id'),
                        'sent' => 0
                    )
                );
                $queueItem->save();
            }
        }
        //return $modx->error->success('', $newsletter);
        return $modx->error->success('');
    } else {
        return $modx->error->failure('');
    }

}
else {
    return $modx->error->failure($modx->lexicon('ditsnews.newsletters.err.nf'));
}





