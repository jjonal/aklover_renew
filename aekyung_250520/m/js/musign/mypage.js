//mypage profile upload, ������ �̹��� ���ε�
function getImageFiles(e) {
    const uploadFiles = [];
    const files = e.currentTarget.files;
    const docFrag = new DocumentFragment();
    
    [...files].forEach(file => {
        if (!file.type.match("image/.*")) {
            alert('�̹��� ���ϸ� ���ε尡 �����մϴ�.');
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            createElement(e, file);
        };
        reader.readAsDataURL(file);
    });
  }
function createElement(e, file) {
    const imagePreview = document.querySelector('.real-image-preview');
    const img = document.createElement('img');
    img.setAttribute('src', e.target.result);
    img.setAttribute('data-file', file.name);
    imagePreview.innerHTML = '';
    imagePreview.appendChild(img);
}
function goBack() {
    window.location.href = '/m/mypage.php';
}

$(document).ready(function(){
    if ( $('.real-upload').length > 0 ) {
        // �������̹��� ���ε�
        const realUpload = document.querySelector('.real-upload');
        const upload = document.querySelector('.btn_upload');    
        upload.addEventListener('click', () => realUpload.click());    
        realUpload.addEventListener('change', getImageFiles);
    }    
    // �������� - ������ư dockbar 
    const footerTop = $('#footer').offset().top; 
    const footerHeight = $('#footer').innerHeight(); 
    $(window).scroll(function(){
        const st = $(window).scrollTop();     
        if ( footerTop < st + footerHeight  ) {
            $('.edit_btn').addClass('hide');
        } else {             
            $('.edit_btn').removeClass('hide');
        }
    });
    // �����н� �˾� ����
    $('.open_pop').click(function(){
        $('#supperpass').show();
    }); 
    $('#supperpass .btn_x').click(function(){
        $('#supperpass').hide();
    }); 
    // ������ 
    $('.my_top .btn_more').click(function(){
        $('.my_top').removeClass('off');
    }); 
    $('.my_top .btn_no').click(function(){
        $('.my_top').addClass('off');
    }); 

    // ���������� �ٵ� Ŭ���� 
     $('body').addClass('body-mypage');

});