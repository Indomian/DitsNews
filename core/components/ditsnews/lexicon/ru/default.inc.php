<?php
/**
 * Default Russian Lexicon Entries for DitsNews
 *
 * @package ditsnews
 * @subpackage lexicon
 */

//general
$_lang['ditsnews'] = 'DitsNews';
$_lang['ditsnews.desc'] = 'Менеджер рассылок для MODX';
$_lang['ditsnews.menu'] = 'Меню';
$_lang['ditsnews.search...'] = 'Поиск...';

//newsletters
$_lang['ditsnews.newsletters'] = 'Рассылки';
$_lang['ditsnews.newsletters.subject'] = 'Тема';
$_lang['ditsnews.newsletters.date'] = 'Дата';
$_lang['ditsnews.newsletters.document'] = 'ID документа';
$_lang['ditsnews.newsletters.attachment'] = 'Вложение';
$_lang['ditsnews.newsletters.total'] = 'Всего';
$_lang['ditsnews.newsletters.sent'] = 'Отправлено';
$_lang['ditsnews.newsletters.new'] = 'Новая Рассылка';
$_lang['ditsnews.newsletters.groups'] = 'Группы';
$_lang['ditsnews.newsletters.remove'] = 'Удалить рассылку';
$_lang['ditsnews.newsletters.remove.title'] = 'Удалить рассылку?';
$_lang['ditsnews.newsletters.remove.confirm'] = 'Вы действительно хотите удалить эту рассылку и все её данные?';
$_lang['ditsnews.newsletters.saved'] = 'Рассылка сохранена (поставлена в очередь)';
$_lang['ditsnews.newsletters.err.save'] = 'Не удалось сохранить и поставить в очередь рассылку';
$_lang['ditsnews.newsletters.err.nf'] = 'Не удалось открыть/найти документ';
$_lang['ditsnews.newsletters.err.remove'] = 'Не удалось удалить рассылку';
$_lang['ditsnews.newsletters.err.wrongext'] = 'Недопустимый тип файла';
$_lang['ditsnews.newsletters.err.fexists'] = 'Файл с таким именем уже существует';

//groups
$_lang['ditsnews.groups'] = 'Группы';
$_lang['ditsnews.groups.name'] = 'Имя';
$_lang['ditsnews.groups.public'] = 'Общий';
$_lang['ditsnews.groups.public.desc'] = 'Общий (можно подписаться самостоятельно)';
$_lang['ditsnews.groups.members'] = 'Участник';
$_lang['ditsnews.groups.new'] = 'Новая группа';
$_lang['ditsnews.groups.edit'] = 'Редактировать группу';
$_lang['ditsnews.groups.remove'] = 'Удалить группу';
$_lang['ditsnews.groups.remove.title'] = 'Удалить группу?';
$_lang['ditsnews.groups.remove.confirm'] = 'Вы уверены, что хотите удалить эту группу? Участники группы не будут удалены.';
$_lang['ditsnews.groups.update'] = 'Обновить группу';
$_lang['ditsnews.groups.saved'] = 'Группа сохранена';
$_lang['ditsnews.groups.err.nf'] = 'Группа не найдена';
$_lang['ditsnews.groups.err.save'] = 'Не удалось сохранить группу';

//subscribers
$_lang['ditsnews.subscribers'] = 'Подписчики';
$_lang['ditsnews.subscribers.firstname'] = 'Имя';
$_lang['ditsnews.subscribers.lastname'] = 'Фамилия';
$_lang['ditsnews.subscribers.company'] = 'Компания';
$_lang['ditsnews.subscribers.email'] = 'Email';
$_lang['ditsnews.subscribers.signupdate'] = 'Дата подписки';
$_lang['ditsnews.subscribers.new'] = 'Новый подписчик';
$_lang['ditsnews.subscribers.exportcsv'] = 'Экспорт в CSV';
$_lang['ditsnews.subscribers.importcsv'] = 'Импорт из CSV';
$_lang['ditsnews.subscribers.importcsv.start'] = 'Начать импорт';
$_lang['ditsnews.subscribers.importcsv.file'] = 'Файл';
$_lang['ditsnews.subscribers.importcsv.results'] = 'Результаты';
$_lang['ditsnews.subscribers.importcsv.err.uploadfile'] = 'Пожалуйста загрузите файл';
$_lang['ditsnews.subscribers.importcsv.err.cantopenfile'] = 'Не могу открыть файл';
$_lang['ditsnews.subscribers.importcsv.err.firstrow'] = 'Первая строка должна содержать названия колонок (первая колонка должна быть email)';
$_lang['ditsnews.subscribers.importcsv.err.cantsaverow'] = 'Не сохранена строка [[+rownum]]';
$_lang['ditsnews.subscribers.importcsv.err.skippedrow'] = 'Пропущена строка [[+rownum]]';
$_lang['ditsnews.subscribers.importcsv.msg.complete'] = 'Импорт завершен. Импортировано [[+importCount]] строк ([[+newCount]] новых)';
$_lang['ditsnews.subscribers.confirm.subject'] = 'Подтвердите подписку на рассылку';
$_lang['ditsnews.subscribers.confirm.success'] = 'Вы подписались на рассылку';
$_lang['ditsnews.subscribers.confirm.err'] = 'Подписчик или секретный код не верный.';
$_lang['ditsnews.subscribers.signup.err.emailunique'] = 'Email адрес уже используется';
$_lang['ditsnews.subscribers.unsubscribe.success'] = 'Вы отписались от рассылки.';
$_lang['ditsnews.subscribers.unsubscribe.err'] = 'Подписчик не найден.';
$_lang['ditsnews.subscribers.active'] = 'Активен';
$_lang['ditsnews.subscribers.groups'] = 'Группы';
$_lang['ditsnews.subscribers.remove'] = 'Удалить подписчика';
$_lang['ditsnews.subscribers.remove.title'] = 'Удалить подписчика?';
$_lang['ditsnews.subscribers.remove.confirm'] = 'Вы действительно хотите удалить этого подписчика?';
$_lang['ditsnews.subscribers.update'] = 'Обновить подписчика';
$_lang['ditsnews.subscribers.saved'] = 'Подписчик сохранен';
$_lang['ditsnews.subscribers.err.save'] = 'Ошибка при сохранении подписчика.';
$_lang['ditsnews.subscribers.err.ae'] = 'Этот email уже используется другим подписчиком.';


//settings
$_lang['ditsnews.settings'] = 'Настройки';
$_lang['ditsnews.settings.name'] = 'Имя';
$_lang['ditsnews.settings.email'] = 'Email';
$_lang['ditsnews.settings.bounceemail'] = 'Email адрес для возврата писем';
$_lang['ditsnews.settings.chunktpl'] = 'Имя чанка с шаблоном письма (если пусто берется шаблон ресурса)';
$_lang['ditsnews.settings.chunksignupmail'] = 'Имя чанка с шаблоном для подтверждения подписки';
$_lang['ditsnews.settings.confirmpage'] = 'Страница подтверждения';
$_lang['ditsnews.settings.unsubscribepage'] = 'Страница отписки от рассылки';
$_lang['ditsnews.settings.template'] = 'Шаблон';
$_lang['ditsnews.settings.saved'] = 'Настройки сохранены';
$_lang['ditsnews.settings.error'] = 'Ошибка при сохранении настроек';
