## Organizations

Organizations - это каталог организаций для CMS MODx. С его помощью, можно, например, организовать продажи юридическим лицам.
Реализованно:
	В форме регистрации пользователя на сайте и в админке, данные Организации загружаются с сервера DaData.
	После отправки формы регистрации, в каталог записываются данные Организации и создается
связь между зарегистрированным пользователем MODx и Организацией.
	Данные Организации и ее связи с профилями пользователей редактируются в админке сайта 
(таблица OrgsUsersLink связывает таблицу Orgs с modUser, таблицей стандартного класса пользователей MODx).
	Пользователям Организации можно назначить группу прав. Группы прав редактируются в админке.
	Группа Администраторов Организации может редактировать права пользователей во фронтэнде и 
создавать инвайты (приглашения) для сотрудников организации на сайт. При регистрации пользователя с кодом инвайта, 
содается связь профиля пользователя с организацией и назначается группа прав, заданная при создании инвайта.
	Организации можно назначить менеджера и скидку. Менеджеры сайта могут самостоятельно зарегистрировать 
Организацию на сайте и отправить инвайт для контактного лица Организации. (Так удобнее. Можно сразу назначить скидку и
нужные данные Организации. Пользователям остается только придумать свой логин, пароль и начинать работать. Ни менеждерам 
сайта, ни администраторам организации не нужно придумывать логины и пароли пользователей. И не нужно заботиться об их отправке 
пользователю и об их сохранности.)
	При создании инвайта, его можно автоматически отправить на емаил пользователя.
	В админке, для организации можно создать купон, временную или разовую скидку, процентную или фиксированную. 
Во фронтэнде, использование купонов не реализованно (Пока нам не требуется.). Но разработчикам думаю не составит особого труда 
написать нужные им сниппеты.

К сожалению, пока нет времени реализовать все задуманное. Да и к совершенству можно двигаться вечно :-). Хотелось бы устранить 
следующие недоработки:
	Переписать запросы AJAX. (Имена процессоров для MODx, как выяснилось должны быть вида name.class.php.)
	Вывести управление типами инвайтов и купонов в админку.
	Оптимизировать запросы к базе данных.
	Не сделаны поиск и фильтрация инвайтов и купонов в админке.
	И т.д.
	
## How to Export

First, clone this repository somewhere on your development machine:

`git clone http://github.com/splittingred/Organizations.git ./`

Then, create the target directory where you want to create the file.

Then, navigate to the directory Organizations is now in, and do this:

`git archive HEAD | (cd /path/where/I/want/my/new/repo/ && tar -xvf -)`

(Windows users can just do git archive HEAD and extract the tar file to wherever
they want.)

Then you can git init or whatever in that directory, and your files will be located
there!

## Configuration

Now, you'll want to change references to Organizations in the files in your
new copied-from-Organizations repo to whatever name of your new Extra will be. Once
you've done that, you can create some System Settings:

- 'mynamespace.core_path' - Point to /path/to/my/extra/core/components/extra/
- 'mynamespace.assets_url' - /path/to/my/extra/assets/components/extra/

Then clear the cache. This will tell the Extra to look for the files located
in these directories, allowing you to develop outside of the MODx webroot!

## Information

Note that if you git archive from this repository, you may not need all of its
functionality. This Extra contains files and the setup to do the following:

- Integrates a custom table of "Items"
- A snippet listing Items sorted by name and templated with a chunk
- A custom manager page to manage Items on

If you do not require all of this functionality, simply remove it and change the
appropriate code.

Also, you'll want to change all the references of 'Organizations' to whatever the
name of your component is.

## Copyright Information

Organizations is distributed as GPL (as MODx Revolution is), but the copyright owner
(Touol) grants all users of Organizations the ability to modify, distribute
and use Organizations in MODx development as they see fit, as long as attribution
is given somewhere in the distributed source of all derivative works.