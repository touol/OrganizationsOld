<div class='users'>
        <table class="table table-bordered table-hover">
        <thead>
            <tr class="active">
                <th>Логин</th>
                <th>Имя пользователя</th>
                <th>Группа пользователя</th>
                <th>Включен</th>
                <th>Действия</th>
            </tr>
        </thead>
        <colgroup>
                    <col width="20%" />
                    <col width="30%" />
                    <col width="30%" />
                    <col width="10%" />
                    <col width="10%" />
        </colgroup>
        <tbody>
            [[+usersOrg]]
        </tbody>
    </table>
</div>
<!-- HTML-код модального окна -->
<div id="EditUserModalBox" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Редактируем пользователя</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">
        <form class="form" action="[[~[[*id]]]]" method="post">
            <h3 id="fullname"></h3>
            <select id="user_group_id" name="user_group_id">
                [[+sel_user_group]]
            </select>
            <input type="hidden" id="user_link_id" name="user_link_id">
            <input type="hidden" name="submitVar" value="OrgEditUser">
        <form>
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
      </div>
    </div>
  </div>
</div>
<script>
function EditUser(user_link_id,username,fullname,user_group_id){
    //EditUser([[+id]],[[+username]],[[+fullname]],[[+user_group_id]]);
    $('#EditUserModalBox #user_link_id').val(user_link_id);
    $('#EditUserModalBox #fullname').html(fullname);
    $('#EditUserModalBox #user_group_id').val(user_group_id);
    $('#EditUserModalBox').modal('show');
};
</script>
<h3>Приглашения (инвайты)</h3>
<input class="std_blue_input" value="Создать инвайт" data-toggle="modal" data-target="#createInviteModalBox" >
<br>
<div class='invites'>
        <table class="table table-bordered table-hover">
        <thead>
            <tr class="active">
                <th>Код приглашения</th>
                <th>Имя пользователя</th>
                <th>Почта</th>
                <th>Группа пользователя</th>
                <th>Отправлено</th>
                <th>Использован</th>
                <th>Действия</th>
            </tr>
        </thead>
        <colgroup>
                    <col width="10%" />
                    <col width="20%" />
                    <col width="20%" />
                    <col width="20%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
        </colgroup>
        <tbody>
            [[+invitesOrg]]
        </tbody>
    </table>
</div>
<!-- HTML-код модального окна -->
<div id="createInviteModalBox" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Создать инвайт</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">
        <form class="form" action="[[~[[*id]]]]" method="post">
            <table class="table" cellpadding="3">
                <tr>
                    <td>Имя пользователя:</td>
                    <td>
                        <input name="fullname" size="30" class="form-control" type="text" value="" />
                    </td>
                </tr>
                <tr>
                    <td>Почта *:</td>
                    <td>
                        <input name="email" size="30" class="form-control" type="text" value="" />
                    </td>
                </tr>
                <tr>
                    <td>Группа прав:</td>
                    <td>
                        <select id="user_group_id" name="user_group_id">
                            [[+sel_user_group]]
                        </select>
                    </td>
                </tr>
            </table>
              <label class="checkbox" style="margin-left: 30px;">
                <input type="checkbox" name="email_send" class="checkbox" checked>Отправить приглашение по почте
              </label>
            
            <input type="hidden" name="submitVar" value="OrgCreateInvite">
        <form>
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
      </div>
    </div>
  </div>
</div>