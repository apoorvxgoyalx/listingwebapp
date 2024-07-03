(function(){
    const fonts = ["cursive", "sans-serif", "serif", "monospace"];
    let captchaValue = "";
  
    function generateCaptcha(){
        let value = btoa(Math.random() * 1000000000);
        value = value.substr(0, 5 + Math.random() * 5);
        captchaValue = value;
  
        // Send the CAPTCHA to the server to store in the session
        fetch("store_captcha.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "captcha=" + encodeURIComponent(captchaValue)
        });
    }
  
    function setCaptcha(){
        let html = captchaValue.split("").map((char) => {
            const rotate = -20 + Math.trunc(Math.random() * 30);
            const font = Math.trunc(Math.random() * fonts.length);
            return `<span
                style="
                    transform:rotate(${rotate}deg);
                    font-family:${fonts[font]}
                "
            >${char}</span>`;
        }).join("");
        document.querySelector(".login-form .captcha .preview").innerHTML = html;
    }
  
    function initCaptcha(){
        document.querySelector(".login-form .captcha .captcha-refresh").addEventListener("click", function(e){
            e.preventDefault();
            generateCaptcha();
            setCaptcha();
        });
        generateCaptcha();
        setCaptcha();
    }
  
    initCaptcha();
  
    document.querySelector(".login-form #login-form").addEventListener("submit", function(event){
        event.preventDefault();
        const inputCaptchaValue = document.querySelector(".login-form .captcha input").value;
  
        // The CAPTCHA value will be verified on the server side
  
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
  
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = xhr.responseText;
                if (response.includes("Login successful")) {
                    window.location.href = "dashboard.php"; 
                } else {
                    alert(response);
                }
            } else {
                alert("An error occurred. Please try again.");
            }
        };
        xhr.send(`username=${username}&password=${password}&captcha=${inputCaptchaValue}`);
    });
  
    const newUserLink = document.querySelector(".new-user a");
    const existingUserLink = document.querySelector(".existing-user a");
    const loginForm = document.querySelector(".login-form");
    const registrationForm = document.querySelector(".registration-form");
  
    newUserLink.addEventListener('click', function(event){
        event.preventDefault();
        loginForm.style.display = "none";
        registrationForm.style.display = "block";
    });
  
    existingUserLink.addEventListener('click', function(event){
        event.preventDefault();
        registrationForm.style.display = "none";
        loginForm.style.display = "block";
    });
  })();
  