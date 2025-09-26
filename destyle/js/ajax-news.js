jQuery(document).ready(function($){
  const container = $('#ajax-news-container');
  const btn       = $('#load-more-news');
  const perPage   = 9;

  btn.on('click', function(e){
    e.preventDefault();

    let page  = parseInt( container.data('paged') );
    const max = parseInt( container.data('max') );
    page++;

    if ( page > max ) {
      btn.hide();
      return;
    }

    btn.find('a').text('Загрузка...');

    $.ajax({
      url:    ajaxNews.ajax_url,
      method: 'POST',
      data: {
        action:   'load_more_news',
        nonce:    ajaxNews.nonce,
        page:     page,
        per_page: perPage
      }
    })
    .done(function(html){
      container.append(html);
      container.data('paged', page);

      if ( page >= max ) {
        btn.hide();
      } else {
        btn.find('a').html('Загрузить ещё&nbsp;<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 11.5H21M21 11.5L17.2642 8M21 11.5L17.2642 15" stroke="#D0043C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>');
      }
    })
    .fail(function(){
      btn.find('a').text('Ошибка, попробуйте снова');
    });
  });
});
