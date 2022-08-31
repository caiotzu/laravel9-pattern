$(function($) {
  $('select[name=company_type]').on('change', function(e) {
    e.preventDefault();
    const companyType = $('select[name=company_type] option:selected').val();

    if(companyType == 'filial')
      $('#divFilial').fadeIn();
    else
      $('#divFilial').fadeOut();
  });
});
