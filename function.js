function showpass(){
    // เลือกไอดี pass และ pass1 มาวนลูปแล้วเช็คว่าเป็น type password ไหม ถ้าใช่จะเปลี่ยน type เป็น text แต่ถ้าไม่ใช่จะให้เป็น password
    document.querySelectorAll('#pass, #pass1').forEach(pass => pass.type = (pass.type === 'password' ? 'text' : 'password'));
}

// เมื่อมีการเพิ่มไฟล์รูปที่ input#img_upload
img_upload.onchange = function(e){
    // เก็บไฟล์ที่ได้มีการเพิม่เข้ามา
    const file = e.target.files[0];
    if(file){
        // สร้างไฟล์รูปภาพชั่วคราว แล้วแสดงที่ img#preview
        preview.src = URL.createObjectURL(file);
    }
}

// เมื่อกดเลือกเงินสดจะทำงาน function นี้
function close_qr(){ 
    // นำ required ออกจาก input สำหรับอัพโหลดสลิป
    document.getElementById('slip_upload').required = false;
    // และนำคลาส show ออก (คลาสนี้จะถูกเพิ่มโดย bootstrap เมื่อคลิก)
    document.getElementById('qr_code').classList.remove('show');
}

// เพิ่ม required ให้กับ input
function open_qr(){ 
    document.getElementById('slip_upload').required = true; 
}

// เมื่อเปลี่ยนแปลงข้อมูลใน form จะนำ disabled ที่ปุ่ม submit ออก
function form_change(){
    document.querySelector('input[type="submit"]').disabled = false;
}
