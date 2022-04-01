let inputField = document.getElementById('file');
let input = document.querySelector('#file');
let dropArea = document.querySelector('#drop-area');
let dropAreaText = document.querySelector('#drop-area-text');

inputField.addEventListener('change', function () {
    if(this.value) {
        if (this.files[0].type !== 'text/csv') {
            dropAreaText.textContent = 'Please upload csv file!';
            dropAreaText.classList.add('danger-error');
            dropArea.classList.add('active-area');
            dropArea.classList.remove('with-file');
            input.value = '';
            input.removeAttribute('hidden');
        } else {
            dropArea.classList.remove('active-area');
            dropArea.classList.add('with-file');
            dropAreaText.classList.remove('danger-error');
            dropAreaText.textContent = this.files[0].name;
            dropAreaText.style.marginBottom = '20px';

            input.style.cursor = 'auto';
            input.setAttribute('hidden', '');
            dropArea.insertAdjacentHTML('afterend',
                '<button class="submit_form_btn" type="submit" form="form">Send</button>');
        }
    }
});


inputField.addEventListener('dragenter', setActiveArea);
inputField.addEventListener('mouseover', setActiveArea);
inputField.addEventListener('dragleave', removeActiveArea);
inputField.addEventListener('mouseleave', removeActiveArea);

function setActiveArea() {
    if (!inputField.value) {
        document.querySelector('#drop-area').classList.add('active-area');
    }
}

function removeActiveArea() {
    document.querySelector('#drop-area').classList.remove('active-area');
}
