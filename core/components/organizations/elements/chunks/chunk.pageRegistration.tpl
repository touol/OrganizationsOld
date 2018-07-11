<script type="text/javascript" src="/assets/components/organizations/js/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript" src="/assets/components/organizations/js/orgs.js"></script>

[[!inviteReg?]]

[[!Register?
    &submitVar=`registerbtn`
    &activationEmailTpl=`lgnActivationEmailTpl`
    &activationEmailSubject=`Спасибо за регистрацию!`
    &submittedResourceId=`79`
    &usergroups=`Покупатели`
    &activation=`0`
    &validate=`nospam:blank,
      username:required,
      password:required,
      password_confirm:password_confirm=^password^,
      fullname:required,
      email:required:email,
      phone:required`
    &placeholderPrefix=`reg.`
    &excludeExtended=`org`
    &postHooks=`loginRegisterHook`
    &preHooks=`CheckConteiner`
]]
<div class="registerMessage">[[!+reg.error.message]]</div>
     
<form class="form-horizontal" action="[[~[[*id]]]]" method="post">
    <input type="hidden" name="nospam" value="[[!+reg.nospam]]" />
    <input type="hidden" name="registerbtn" value="1" />
    
    <input type="hidden" id='longname' name="org[longname]" value="" />
    <input type="hidden" id='kpp' name="org[kpp]" value="" />
    <input type="hidden" id='ur_address' name="org[ur_address]" value="" />
    <input type="hidden" id='p_address' name="org[p_address]" value="" />
    <div class="form-group clear-both">
        <label for="haveteam" class="col-sm-2 col-md-2 control-label">Мой статус:</label>
    	<div class="col-sm-10 col-md-10">
    		<div id="statusBtn" class="btn-group btn-radio-group">
    			<a class="btn btn-primary btn-sm active" data-toggle="lico" data-title="urlico">Юридическое лицо</a>
    			<a class="btn btn-primary btn-sm notActive" data-toggle="lico" data-title="fizlico">Физическое Люцо</a>
    		</div>
    		<input type="hidden" name="lico" id="lico" value="[[!+inv.lico:isempty=`urlico`]]">
    	</div>
    </div>
    <div class="form-group">
        <label for="username" class="col-xs-2 control-label">Логин*:</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" id="username" name="username" value="[[!+reg.username]]" placeholder="Введите логин">
            <div class="error">[[!+reg.error.username]]</div>
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-xs-2 control-label">Пароль*:</label>
        <div class="col-xs-10">
            <input type="password" class="form-control" id="password" name="password" value="[[!+reg.password]]" placeholder="Введите пароль">
            <div class="error">[[!+reg.error.password]]</div>
        </div>
    </div>
    <div class="form-group">
        <label for="password_confirm" class="col-xs-2 control-label">Повторите пароль*:</label>
        <div class="col-xs-10">
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" value="[[!+reg.password_confirm]]" placeholder="Повторите пароль">
            <div class="error">[[!+reg.error.password_confirm]]</div>
        </div>
    </div>
    <div class="form-group">
        <label for="fullname" class="col-xs-2 control-label">Ф.И.О.*:</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" id="fullname" name="fullname" value="[[!+reg.fullname]]" placeholder="Введите Ф.И.О.">
            <div class="error">[[!+reg.error.fullname]]</div>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-xs-2 control-label">Адрес эл. почты*:</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" id="email" name="email" value="[[!+reg.email]]" placeholder="Введите адрес эл. почты">
            <div class="error">[[!+reg.error.email]]</div>
        </div>
    </div>
    <div class="form-group">
        <label for="phone" class="col-xs-2 control-label">Телефон*:</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" id="phone" name="phone" value="[[!+reg.phone]]" placeholder="Введите телефон">
            <div class="error">[[!+reg.error.phone]]</div>
        </div>
    </div>
    <div class="form-group urlico-block">
        <label for="shortname" class="col-xs-2 control-label">Имя организации*:</label>
        <div class="col-xs-10">
            <input type="text" class="form-control org-combo-dadata" name="org[shortname]" id="shortname" value='[[!+inv.shortname:isempty=`[[!+reg.orgshortname ]]`]]' placeholder="Введите имя организации">
            <div class="error">[[!+reg.error.org_shortname ]]</div>
        </div>
    </div>
    <div class="form-group urlico-block">
        <label for="inn" class="col-xs-2 control-label">ИНН:</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" name="org[inn]" id="inn" value="[[!+inv.inn:isempty=`[[!+reg.orginn ]]` ]]" placeholder="Введите ИНН">
            <div class="error">[[!+reg.error.org_inn ]]</div>
        </div>
    </div>
    <div class="form-group">
        <label for="invite_code" class="col-xs-2 control-label">Код приглашения:</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" name="invite_code" id="invite_code" value="[[!+inv.invite_code:isempty=`[[!+reg.invite_code]]`]]" placeholder="Введите код приглашения">
            <div class="error">[[!+inv.error]]</div>
        </div>
    </div>
    <div class="form-group">
        <label for="invite_code" class="col-xs-2 control-label"></label>
        <div class="col-xs-10">
            <p>
                Заполняя данную форму, вы принимаете условия <a href=[[~99]]>Соглашения об использовании сайта</a>, в том числе в части обработки и использования персональных данных
    		</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </div>
</form>
<style>
    .error{
        color:red;
    }
</style>
<script>
    $(document).ready(function(){
    	$('#statusBtn a').on('click', function(){
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#'+tog).prop('value', sel);
            
            $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
            
            if (sel == 'urlico') {
                $('.urlico-block').fadeIn('fast');
                $('.fizlico-block').fadeOut('fast')
            }
            else {
                $('.urlico-block').fadeOut('fast');
                $('.fizlico-block').fadeIn('fast');
            }
        });
        if($('#lico').val() ==''){
            $('#lico').prop('value', 'urlico');
        }else if($('#lico').val() =='fizlico'){
            $('#statusBtn a').trigger('click');
        }
    });
    $('#username').change(function() { 
        if(this.value.indexOf('"') > -1){
           alert('Логин не может содержать знак кавычки (").');
           this.value=this.value.replace(/"/g,'');
        }
    });
    
</script>