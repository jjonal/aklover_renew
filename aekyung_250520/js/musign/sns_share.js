$(document).ready(function(){
     // 공유하기 링크 개발 
     $('.btn_share').click(function(){
         $('.share_inner').toggleClass('on');
         if($(this).hasClass('dim_on')) {
            $('.dim').show();
         }
     });
     $('.btn_close').click(function(){
        $(this).parents('.share_inner').removeClass('on');
        if($(this).hasClass('dim_off')) {
            $('.dim').hide();
         }
    });
    
     document.getElementById('copyLinkBtn').addEventListener('click', function() {
         var currentURL = window.location.href;
         copyToClipboard(currentURL);
     });
     
     function copyToClipboard(text) {
         var input = document.createElement('textarea');
         input.innerHTML = text;
         document.body.appendChild(input);
         input.select();
         document.execCommand('copy');
         document.body.removeChild(input);
         confirm('링크가 복사되었습니다.');
     }

 
});