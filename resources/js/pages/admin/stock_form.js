import { find, gsapTL } from '../../utils';

const inGroup = find('#in-group');
const modal = find('#attachment-modal');
const fileInput = find('#file_input');
const previewBtn = find('#preview-attachment');
const oldAtt = find('#old-attachment', modal);
const newAtt = find('#new-attachment', modal);
const oldAttBtn = find('#old-att-btn', modal);
const newAttBtn = find('#new-att-btn', modal);

find('#type-in').addEventListener('click', () => {
    inGroup.classList.remove('hidden');
    gsapTL().fromTo(inGroup, {
        height: 0
    }, {
        height: 'auto',
        duration: 0.3
    });

    find('label[for="merchant_name"]').innerHTML = 'Supplier name';
    find('label[for="merchant_contact"]').innerHTML = 'Supplier contact';
});
find('#type-out').addEventListener('click', () => {
    gsapTL().to(inGroup, {
        height: 0,
        duration: 0.3
    }).then(() => {
        inGroup.classList.add('hidden');
    });
    find('label[for="merchant_name"]').innerHTML = 'Buyer name';
    find('label[for="merchant_contact"]').innerHTML = 'Buyer contact';
});

fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    newAtt.innerHTML = '';
    let item;
    if (file.name.match(/\.pdf$/)){
        item = document.createElement('iframe');
        item.className = 'w-full h-full';
    } else {
        item = document.createElement('img');
        item.className = 'w-full h-full object-contain';
    }
    item.src = URL.createObjectURL(file);
    newAtt.appendChild(item);
    
    if (previewBtn.getAttribute('data-old')) {
        return;
    }
    if (fileInput.files.length > 0) {
        previewBtn.classList.remove('hidden');
    } else {
        previewBtn.classList.add('hidden');
    }

});

previewBtn.addEventListener('click', () => {
    if (fileInput.files.length == 0 && !previewBtn.getAttribute('data-old')) {
        return;
    }
    modal.classList.remove('hidden');
    modal.classList.add('flex');
});

find('button', modal).addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
});

oldAttBtn.addEventListener('click', () => {
    newAttBtn.classList.remove('border-b-2');
    oldAttBtn.classList.add('border-b-2');
    
    newAtt.classList.add('hidden');
    oldAtt.classList.remove('hidden');
});
newAttBtn.addEventListener('click', () => {
    newAttBtn.classList.add('border-b-2');
    oldAttBtn.classList.remove('border-b-2');
    
    newAtt.classList.remove('hidden');
    oldAtt.classList.add('hidden');
});