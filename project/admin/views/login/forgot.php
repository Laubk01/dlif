<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src="images/draw2.svg" class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form method="POST" action="login.php?action=send">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input name="correo" type="email" id="form1Example13" class="form-control form-control-lg" />
                        <label class="form-label" for="form1Example13">Email address To Recovery</label>
                    </div>

                    <!-- Submit button -->
                    <input name="enviar" value="Recover" type="submit"
                        class="btn btn-primary btn-lg btn-block"></button>

                </form>
            </div>
        </div>
    </div>
</section>