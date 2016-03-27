<tr>
    <td>
        [[+username]]([[+user_id]])
    </td>
    <td>
        [[+fullname]]
    </td>
    <td>
        [[+user_group_name]]
    </td>
    <td >
        <div style="color: [[+active_color]];">
            [[+active_ru]]
        </div>
    </td>
    <td>
        <a href="/nojs.html" target="_blank" onclick="EditUser([[+id]],'[[+username]]','[[+fullname]]',[[+user_group_id]]);return false">
            <span  class="glyphicon glyphicon-edit"></span>
        </a>
        <a href="[[~[[*id]]]]?action=power&user_link_id=[[+id]]" style="[[+hidden]]">
            <span class="glyphicon glyphicon-off" style="color:[[+power_color]]"></span>
        </a>
    </td>
</tr>
