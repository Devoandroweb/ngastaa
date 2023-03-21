<script type="text/javascript">
/* Reimbursement */
function initReimbursement(value){
        let getReimbursement = (url) => { 
            let loading = loadingProccesText($('.Reimbursement'))
            $.ajax({url: url, success: function(data){
                $('.Reimbursement').empty()
                clearInterval(loading)
                var data = $.map(data, function (item) {
                    return {
                        text: item['label'],
                        id: item['kode_reimbursement'],
                    }
                })
                
                if(value == null && data.length != 0){
                    value = data[0].id;
                }
                console.log(data);
                console.log("value reimbursement "+value);
                $('.Reimbursement').removeAttr("disabled")
                $('.Reimbursement').select2({
                    placeholder:"Pilih reimbursement atau ketik disini",
                    data : data
                }).val(value).trigger("change");
            }});
        }
        getReimbursement("{{route('master.reimbursement.json')}}")
    }
/* END JABATAN */
</script>