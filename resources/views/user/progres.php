<div class="container">
    <div class="row" style="padding-top: 20px">
        <div class="col-md-12">
            <div class="progress">
                <div class="progress-bar" id="pro" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <br>
            <button class="btn btn-success" onclick="klik()"> UPLOAD </button> <br> <br>
            <p class="alert-success" id="status"></p>
        </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">

                function klik() {
                    var pro = document.getElementById("pro");
                    var width = 1;
                    var id = setInterval(kondisiPro, 10);

                    function kondisiPro() {
                        if (width >= 100) {
                            clearInterval(id);
                        } else {
                            width++;
                            pro.style.width = width + '%';
                            pro.innerHTML = width + "%";
                        }

                        if (width == 100) {

                            document.getElementById("status").innerHTML = " Berhasil Di Upload ";
                        }
                    }
                }
</script>