// submit data
var _LOADING = buildLoading();
var validateTooltipInvalid = (msg)=>{
    return `<div class="invalid-feedback">${msg}</div>`;
}

function saveForm(form,url,statusSubmit,method = "post",igoneinput = [], withFile = false){
    // -----------------------------------
    return new Promise(output => {

        var validate = false;
        var msg = null;
        var data = null;
        validate = validateInput(form,igoneinput);
        if(statusSubmit == 1){//new
            msg = 'Menambahkan';
        }else if(statusSubmit == 2){//update
            msg = 'Mengubah';
        }

        if(withFile){
            data = new FormData(form[0]);
        }else{
            console.log("bukan file");
            data = form.serialize()+ '&_method=' + method;
        }
        if(validate){
            $("#btn-submit").attr('disabled','disabled');

            var option = {
                type: method,
                url: url,
                data: data,
                async:false,
                dataType: "JSON",
                success: function (response) {

                    iziToast.success({
                        title: 'Success',
                        message: 'Success '+msg+' data',
                        position: 'bottomRight'
                    });
                    output(true)

                },
                error : function (response){
                    errorValidateMessage(response.responseJSON.errors)
                    loadingFormStop()
                }
            }
            if(withFile){
                option.processData = false
                option.contentType = false
            }
            $.ajax(option);
        }else{
            loadingFormStop();
        }
        output(false)
    })
    // ---------------------------

}
function loadingFormStart(){
    $(".target-view").addClass("d-none");
    $(".loading").html(_LOADING);
};
function loadingFormStop(){
    $(".target-view").removeClass("d-none");
    $(".loading").empty();
};

function validateInput(form,ingoneInputName = [], errorMessage = []){
    var output = true;
    var validateInput = 0;
    var input = form.find('input');
    var textarea = form.find('textarea');
    var select = form.find('select');
    var allInput = [{el:input,text:'input'},{el:select,text:'select'},{el:textarea,text:'textarea'}];
    console.log(allInput);
    allInput.forEach(function(v,i){
        $.each(v.el, function (indexInArray,element) {
            var name = element.name;
            var checked = 0;
            //cek input ignore
            //jika input ada maka true, jika true maka skip in-valid
            var ignoreInput = checkInputIgnore(ingoneInputName,name);
            var nameElement = v.text+"[name='"+name+"']";
            if(!ignoreInput){
                // console.log(element.type)

                if(element.type != "radio"){
                    console.log(element.value)
                    if(element.value == "" || element.value == 0){
                        $(nameElement).addClass("is-invalid");
                        $(nameElement).siblings(".select2-container").find(".select2-selection--single").addClass("is-invalid");
                        validateInput++;
                    }else{
                        $(nameElement).siblings(".select2-container").find(".select2-selection--single").removeClass("is-invalid");
                        $(nameElement).removeClass("is-invalid");
                    }
                }else{
                    // console.log("Radio Check e piro ? : "+$(v.text+"[name='"+name+"']:checked").length)
                    if($(nameElement+":checked").length > 0){
                        $(nameElement).removeClass("is-invalid");
                    }else{
                        $(nameElement).addClass("is-invalid");
                    }
                }
            }
        });
    })
    if(validateInput != 0){
        console.log(validateInput);
        output = false;
    }
    return output;
}
function errorValidateMessage(message) {
    console.log(message);
    for(var property in message ) {
        $(`[name='${property}']`).addClass("is-invalid");
        $(`[name='${property}']`).siblings(".is-invalid").remove()
        $(`[name='${property}']`).siblings(".invalid-feedback").remove()
        $(`[name='${property}']`).after(validateTooltipInvalid(message[property][0]))
    }
}
function checkInputIgnore(inputName = [], name = ""){
    var result = false;
    inputName.forEach(function(item,index){
        if(item == name){
            result = true;
        }
    });
    return result;
}
