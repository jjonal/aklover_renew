//mypage profile upload, 프로필 이미지 업로드
function getImageFiles(e) {
    const uploadFiles = [];
    const files = e.currentTarget.files;
    const docFrag = new DocumentFragment();
    
    [...files].forEach(file => {
        if (!file.type.match("image/.*")) {
            alert('이미지 파일만 업로드가 가능합니다.');
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
        // 프로필이미지 업로드
        const realUpload = document.querySelector('.real-upload');
        const upload = document.querySelector('.btn_upload');    
        upload.addEventListener('click', () => realUpload.click());    
        realUpload.addEventListener('change', getImageFiles);

    }
    // 슈퍼패스 팝업 오픈
    $('.open_pop').click(function(){
        $('#supperpass').show();
    }); 

});