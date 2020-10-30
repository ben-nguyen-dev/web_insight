$(document).ready(function(){
    var resultArr = [];
    $("#tags").keypress(function(event) {
        $keyCode = event.which | event.keyCode;
        if ($keyCode == 13) {
            event.preventDefault();
            $value = $(this).val();
            if ($value != '') {
                resultArr.push($value.toLowerCase());
            }
            $html_output = `<li>
                            <div class="list-tagger" data-html=`+ $value.toLowerCase() +`>
                                <h4>` + $value.toUpperCase() + `<span><img src="/wp-content/themes/publicinsight/assets/images/x.png" alt=""></span></h4>
                            </div>   
                        </li>`;
            $('.result-taggar').find('ul').append($html_output);
            $(this).val('');
        }
    });
    $(document).on("click",".list-tagger h4",function() {
        var value = $(this).parent().data('html');
         resultArr.splice(resultArr.indexOf(value.toString().toLowerCase()), 1);
        $(this).parents('ul li').remove();
    });
   
    $('#slider').slider({
        min:0,
        max:100,
        value:3,
        animate: true,
    });
    $(document). on("click",".btn-mb-pr",function(event) {
        event.preventDefault();
        $(this).parents('.content-box').next().show().prev().hide();
    });
    $(document).on('click','.btn-mb-lf',function(event) {
        event.preventDefault();
        $(this).parents('.content-box').prev().show().next().hide();
    });
    $(document).on('input','.form-mb-register', function() {
        var value_company = $(this).val();
        if (value_company != '') {
            $html = ` <li class="list-group-item item">
                <div class="box-item">
                    <div class="box-top">
                        <h5>PublicInsight Holding AB</h5>
                        <input type="radio" name="addresss" checked>
                        <span class="box-check"></span>
                    </div>
                    <div class="box-content">
                        <p>
                        555555-5555 Stockholm <br>
                        Konsultverksamhet
                        </p>
                    </div>
                </div>
            </li>`;
        } else {
            $html = '';
        }
        $('.list-bm-item').find('.list-group').html($html);
    });
});