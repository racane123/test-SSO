<!DOCTYPE html>
<html>
<head>
    <title>Access Token Example</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<style>

.container {
    max-width: 400px;
    margin: 0 auto;
    text-align: center;
    padding: 20px;
}

input, button {
    margin: 10px 0;
}

button {
    padding: 10px 20px;
}
</style>
<body>
    <div class="container" id="form-container">
        <h1>Register</h1>
        <form method="POST">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <button type="submit" id='submitBtn'>Register</button>
        </form>
    </div>

    <div class="" id="login-form">
        <h1>Login Form</h1>
        <form id="loginForm" method="POST">
            <input type="email" id="loginEmail" name="email" placeholder="Email" required>
            <input type="password" id="loginPassword" name="password" placeholder="Password" required>
            <button type="submit" id="loginSubmit">Log in</button>
        </form>
    </div>

    <div id="results">

    </div>


    <script>
function submitForm(event){
    event.preventDefault()


    if($('#username').val()=== '' || $('#password').val() === '' || $('#email')){
        $('#results').text("please fill up the empty fields")
        return
    }


    var  formData = {
        'username': $('#username').val(),
        'password': $('#password').val(),
        'email' : $('#email').val()
    }

    $.ajax({
        type:"POST",
        url:'register.php',
        data:formData,
        dataType:'json',
        encode:TRUE,
        success:function(xhr, response){
            $('#results').text('Sucessful subimitting data')
            $('#form-container')[0].reset();

            $('#form-container').load(location.href + '#form-container')
        },
        error:function(xhr, status, error){
            $('#results').text("Error Submitting the Data");
            console.error("Submission Error: ", xhr.status);
        }

    })
}


    $(document).ready(function() {
        // Function to handle form submission
        $('#loginForm').submit(function(event) {
            event.preventDefault();

            // Retrieve email and password values
            var email = $('#loginEmail').val();
            var password = $('#loginPassword').val();

            // AJAX call to send login data to server
            $.ajax({
                type: 'POST',
                url: 'login.php',
                data: {
                    email: email,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    // Check if login was successful
                    if (response.success) {
                        // Redirect to index.php
                        window.location.href = 'index.php';
                    } else {
                        // Display error message
                        $('#results').text('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    $('#results').text('Error: ' + xhr.responseText);
                }
            });
        });
    });


</script>
</body>
</html>