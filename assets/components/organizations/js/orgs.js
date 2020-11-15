function setTypeaheadOrgs(){
    $('.org-combo-dadata').typeahead({
            minLength:2
            //источник данных
            ,source: function (query, process) {
               return $.post('/assets/components/organizations/action.php', 
                   {query:query,
                    action: 'orgs/getdadata',
    			    suggest: 'party',
                    },
                     function (response) {
                          //console.info('response',response);
                          var data = new Array();
                          if(response.success){
                              $.each(response.results, function(i, val)
                              {
                                data.push(JSON.stringify(val)+'#'+val.search_value);
                              })
                              return process(data);
                          }
                        },
                     'json'
                     );
              }
              //источник данных
              , highlighter: function(item) {
                  var parts = item.split('#');
                  parts.shift();
                  return parts.join('_');
              }
              //вывод данных в выпадающем списке
              //действие, выполняемое при выборе елемента из списка
              , updater: function(item) {
                         var parts = item.split('#');
                         var suggest = JSON.parse(parts.shift());
                         if(suggest.data.name.full_with_opf != null){$('#longname').val(suggest.data.name.full_with_opf);}
                         if(suggest.data.inn != null){$('#inn').val(suggest.data.inn);}
                         if(suggest.data.kpp != null){$('#kpp').val(suggest.data.kpp);}
                         if(suggest.data.ogrn != null){$('#ogrn').val(suggest.data.ogrn);}
                         if(suggest.data.okpo != null){$('#okpo').val(suggest.data.okpo);}
                         if(suggest.data.management.name != null){$('#director').val(suggest.data.management.name);}
                         if(suggest.data.address.value != null){$('#ur_address').val(suggest.data.address.value);}
                         if(suggest.data.address.value != null){$('#postal_address').val(suggest.data.address.value);}
						 
						 if(!$('[name=org_id]').length>0){
							 $.post('/assets/components/organizations/action.php', 
							   {shortname: suggest.value,
								action: 'orgs/testorg',
								inn: suggest.data.inn,
								},
								 function (response) {
									  //console.info('response',response);
									  if(response.data.exist){
										  alert('Организация '+suggest.value+' уже зарегистрированна на сайте. Администратору организации '+suggest.value+' будет направлен запрос на подключение к ней Вашей учетной записи.');
									  }
									},
								 'json'
								 );
						 }
						 
                         return suggest.value;
                       }
              //действие, выполняемое при выборе елемента из списка
              }
    );
    $('.bank-combo-dadata').typeahead({
            minLength:2
            //источник данных
            ,source: function (query, process) {
               return $.post('/assets/components/organizations/action.php', 
                   {query:query,
                    action: 'orgs/getdadata',
    			    suggest: 'bank',
                    },
                     function (response) {
                          var data = new Array();
                          if(response.success){
                              $.each(response.results, function(i, val)
                              {
                                data.push(JSON.stringify(val)+'#'+val.value);
                              })
                              return process(data);
                          }
                        },
                     'json'
                     );
              }
              //источник данных
              , highlighter: function(item) {
                  var parts = item.split('#');
                  parts.shift();
                  return parts.join('_');
              }
              //вывод данных в выпадающем списке
              //действие, выполняемое при выборе елемента из списка
              , updater: function(item) {
                         var parts = item.split('#');
                         var suggest = JSON.parse(parts.shift());
                         if(suggest.data.bic != null){$('#bank_bik').val(suggest.data.bic);}
                         if(suggest.data.correspondent_account != null){$('#bank_kor_acc').val(suggest.data.correspondent_account);}
                         return suggest.value;
                       }
              //действие, выполняемое при выборе елемента из списка
              }
    );
    $('.fio-combo-dadata').typeahead({
            minLength:2
            //источник данных
            ,source: function (query, process) {
               return $.post('/assets/components/organizations/action.php', 
                   {query:query,
                    action: 'orgs/getdadata',
    			    suggest: 'fio',
                    },
                     function (response) {
                          //console.info('response',response);
                          var data = new Array();
                          if(response.success){
                              $.each(response.results, function(i, val)
                              {
                                data.push(val.value);
                              })
                              return process(data);
                          }
                        },
                     'json'
                     );
              }
              //источник данных
              //действие, выполняемое при выборе елемента из списка
              , updater: function(item) {
                         return item;
                       }
              //действие, выполняемое при выборе елемента из списка
              }
    );
    $('.addr-combo-dadata').typeahead({
            minLength:2
            //источник данных
            ,source: function (query, process) {
               return $.post('/assets/components/organizations/action.php', 
                   {query:query,
                    action: 'orgs/getdadata',
    			    suggest: 'address',
                    },
                     function (response) {
                          //console.info('response',response);
                          var data = new Array();
                          if(response.success){
                              $.each(response.results, function(i, val)
                              {
                                data.push(val.value);
                              })
                              return process(data);
                          }
                        },
                     'json'
                     );
              }
              //источник данных
              //действие, выполняемое при выборе елемента из списка
              , updater: function(item) {
                         return item;
                       }
              //действие, выполняемое при выборе елемента из списка
              }
    );
    $('.email-combo-dadata').typeahead({
            minLength:2
            //источник данных
            ,source: function (query, process) {
               return $.post('/assets/components/organizations/action.php', 
                   {query:query,
                    action: 'orgs/getdadata',
    			    suggest: 'email',
                    },
                     function (response) {
                          //console.info('response',response);
                          var data = new Array();
                          if(response.success){
                              $.each(response.results, function(i, val)
                              {
                                data.push(val.value);
                              })
                              return process(data);
                          }
                        },
                     'json'
                     );
              }
              //источник данных
              //действие, выполняемое при выборе елемента из списка
              , updater: function(item) {
                         return item;
                       }
              //действие, выполняемое при выборе елемента из списка
              }
    );
}
$( document ).ready(function() {
    //console.log( "ready!" );
  setTypeaheadOrgs();
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
  
  $('#username').change(function() { 
    if(this.value.indexOf('"') > -1){
       alert('Логин не может содержать знак кавычки (").');
       this.value=this.value.replace(/"/g,'');
    }
  });
});