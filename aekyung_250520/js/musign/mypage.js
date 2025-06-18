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

$(document).ready(function(){

    if ( $('.real-upload').length > 0 ) {
        // �������̹��� ���ε�
        const realUpload = document.querySelector('.real-upload');
        const upload = document.querySelector('.btn_upload');    
        upload.addEventListener('click', () => realUpload.click());    
        realUpload.addEventListener('change', getImageFiles);

    }
    // �����н� �˾� ����
    $('.open_pop').click(function(){
        $('#supperpass').show();
    }); 

});