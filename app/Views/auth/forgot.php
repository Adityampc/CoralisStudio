<head>
    <title><?= $page_title ?? "PAGE TITLE" ?></title>
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/form.css">
</head>

<body class="align">

    <div class="login">

        <header class="login__header">
            <h2><svg class="icon">
                    <use xlink:href="#icon-lock" />
                </svg>Forgot Password</h2>
        </header>

        <form action="#" class="login__form" id="form" method="POST">
            <div class="form-floating">
                <input autocomplete="off" required type="email" class="form-control" name="email" id="email" placeholder="name@example.com" value="">
                <label for="email">Email address</label>
            </div>
            <div id="msgSuccess" style="display: none;" class="alert alert-success ">
            </div>
            <div id="msgError" style="display: none;" class="alert alert-danger ">
            </div>
            <div>Already have an account? <a href="<?= base_url('signin') ?>">Sign In</a></div>
            <div>
                <button disabled class="btn btn-primary w-100" id="btn-submit" type="submit">
                    <div id="loadBtn" style="display: none;" class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span id="txtBtn">Submit</span>
                </button>
            </div>

        </form>

    </div>

    <svg xmlns="http://www.w3.org/2000/svg" class="icons">

        <symbol id="icon-lock" viewBox="0 0 448 512">
            <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" />
        </symbol>
    </svg>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function gaem(err, errMsg = "There was a problem contacting the server") {
            if (!err) return errMsg;
            try {
                if (typeof err.data.message == 'string') errMsg = err.data.message;
            } catch (error) {

            }
            try {
                if (typeof err.response.data.messages.message == 'string') errMsg = err.response.data.messages.message;
            } catch (error) {}
            try {
                if (typeof err.response.data.messages.error == 'string') errMsg = err.response.data.messages.error;
            } catch (error) {

            }
            try {
                if (typeof err.response.data.message == 'string') errMsg = err.response.data.message;
                if (typeof err.response.data.file == 'string') errMsg += " | " + err.response.data.file;
                if (typeof err.response.data.line == 'number') errMsg += " | " + err.response.data.line;
            } catch (error) {

            }
            return errMsg;
        }
    </script>
    <script>
        let form = document.getElementById('form');
        let email = document.getElementById('email');
        let btnSubmit = document.getElementById('btn-submit');
        let msgSuccess = document.getElementById('msgSuccess');
        let msgError = document.getElementById('msgError');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            msgSuccess.style.display = 'none';
            msgError.style.display = 'none';
            let data = new FormData(this);
            showSpinner();
            axios.post('/forgot', data)
                .then(function(response) {
                    hideSpinner();
                    if (response.data.redirect) return window.location.href = response.data.redirect;
                    msgSuccess.style.display = '';
                    msgError.style.display = 'none';
                    msgSuccess.innerHTML = `Request successful, please follow <a href='${response.data.link}'>here</a>`;
                })
                .catch(function(error) {
                    hideSpinner();
                    msgSuccess.style.display = 'none';
                    msgError.style.display = '';
                    msgError.innerHTML = gaem(error);
                });
        });
        email.addEventListener('input', checkFieldOk);


        function checkFieldOk(e) {
            if (document.getElementById('email').value.length == 0) return btnSubmit.setAttribute('disabled', 'disabled');
            return btnSubmit.removeAttribute('disabled');
        }

        function hideSpinner() {
            document.getElementById('txtBtn').style.display = '';
            document.getElementById('loadBtn').style.display = 'none';
        }

        function showSpinner() {
            document.getElementById('txtBtn').style.display = 'none';
            document.getElementById('loadBtn').style.display = '';
        }
    </script>
</body>

<!-- https://fontawesome.com/icons/lock?style=solid -->