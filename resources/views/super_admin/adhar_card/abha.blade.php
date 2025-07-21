<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eaccuster</title>

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/toastr/css/toastr.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/font-awesome/css/all.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/datatable/css/datatable.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/css/custom_css.css') }}" rel="stylesheet">
</head>

<body>
<main>
    <div class="bg_abha">
        <section class="section register">
            <div class="abha_detail_main">
                
                <div class="abha_detail_right">
                    <h2>Create ABHA Number in 3 Steps</h2>
                    <p class="mb-5">
                        Create ABHA Address and store all your medical records in one place. Take part in the Ayushman Bharat Digital Mission (ABDM) and get started on your digital health journey.
                    </p>


                    <ul>
                        <li>
                            <div class="d-flex">
                                <div class="step-count">1</div>
                                <div class="step-content">
                                    <h3>Link mobile number with ABHA</h3>
                                    <p>Enter your mobile number and verify with OTP to link with ABHA Address.</p>
                                </div>
                            </div>
                        </li>


                         <li>
                            <div class="d-flex">
                                <div class="step-count">2</div>
                                <div class="step-content">
                                    <h3>Verify Aadhaar Details</h3>
                                    <p>Enter your Aadhaar number and verify with OTP received on Aadhaar linked mobile number.</p>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="d-flex">
                                <div class="step-count">2</div>
                                <div class="step-content">
                                    <h3>Link mobile number with ABHA</h3>
                                    <p>Enter your mobile number and verify with OTP to link with ABHA Address.</p>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <img class="abha-logo-one" src="{{ asset('public/admin_images/abha/logo-trans.png') }}" alt="">

                    <img class="abha-logo-two" src="{{ asset('public/admin_images/abha/ABDM.png') }}" alt="">

                </div>

                <div class="abha_detail_left" id="step1">
                    <div class="">
                        <div class="abha-bg">
                            <div class="right-button">
                                <button class="btn login-accuster-button">login eAccuster</button>
                                <button class="btn download-app-button">Download App</button>
                            </div>

                            <div class="adhar-number">
                                <label for="">Enter your Aadhar Number</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="xxxx">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="xxxx">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control"  placeholder="xxxx">
                                    </div>  
                                </div>
                            </div>

                            <div class="consent-container">
                                <ul>
                                    <li>
                                        <div class="consent-list">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <p>I am voluntarily sharing my Aadhaar Number / Virtual ID issued by the Unique Identification Authority of India ("UIDAI"), and my demographic information for the purpose of creating an Ayushman Bharat Health Account number (ABHA number) and Ayushman Bharat Health Account address (ABHA Address"). I authorize NHA to use my Aadhaar number / Virtual ID for performing Aadhaar based authentication with UIDAI as per the provisions of the Aadhaar (Targeted Delivery of Financial and other Subsidies, Benefits and Services) Act, 2016 for the aforesaid purpose. I understand that UIDAI will share my e-KYC details, or response of "Yes" with NHA upon successful authentication.</p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="consent-list">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                            <p>I consent to usage of my ABHA address and ABHA number for linking of my legacy (past) government health records and those which will be generated during this encounter.</p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="consent-list">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                            <p>I authorize the sharing of all my health records with healthcare provider(s) for the purpose of providing healthcare services to me during this encounter.</p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="consent-list">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                            <p>I consent to the anonymization and subsequent use of my government health records for public health purposes.</p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="consent-list">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                            <p>I 
                                                <input type="text" style="width: 100px;" placeholder="Patient Name">
                                                benefiaciary have been explained about the consent as stated above and hereby provide my consent for the aforementioned purposes.
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="continue-button text-center">
                                <a class="btn btn-info w-100 mt-3 text-white">Continue</a>
                            </div>


                            <div class="sing-up-adhar mt-3">
                                <p>Don’t have Aadhaar? <a href="#" target="_blank" id="useMobileLink"> Use Mobile Number  > </a> </p>
                            </div>


                            <div class="certified-by">
                                <img src="{{ asset('public/admin_images/abha/certified-by.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="abha_detail_left" id="step2">
                    <div class="">
                        <div class="abha-bg">
                            <div class="right-button">
                                <button class="btn login-accuster-button">login eAccuster</button>
                                <button class="btn download-app-button">Download App</button>
                            </div>

                            <div class="container-box">
                                <h5>Confirm OTP</h5>
                                <p>OTP sent to Aadhar registered mobile number ending with ******4995</p>

                                <!-- Step 1 -->
                                <div class="step-container">
                                    <div class="step-marker">1</div>
                                    <div class="w-100">
                                        <div class="otp-inputs d-flex justify-content-between" id="otp">
                                            <input class="form-control text-center rounded" id="first" maxlength="1" />
                                            <input class="form-control text-center rounded" id="second" maxlength="1" />
                                            <input class="form-control text-center rounded" id="third" maxlength="1" />
                                            <input class="form-control text-center rounded" id="fourth" maxlength="1" />
                                            <input class="form-control text-center rounded" id="fifth" maxlength="1" />
                                            <input class="form-control text-center rounded" id="sixth" maxlength="1" />
                                        </div>
                                        <small class="d-block mt-2" id="timer"></small>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="step-container">
                                    <div class="step-marker last">2</div>
                                    <div class="w-100">
                                        <label class="form-label">Add mobile number you want to link with ABHA</label>
                                        <label class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-telephone text-white"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="+91 xxx xxx xxxx">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-info w-100 mt-3" id="resendBtn" onclick="startResendTimer()">Continue</button>
                            </div>

                            <div class="certified-by">
                                <img src="{{ asset('public/admin_images/abha/certified-by.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="abha_detail_left" id="step3">
                    <div class="abha-bg">
                        <div class="right-button">
                            <button class="btn login-accuster-button">login eAccuster</button>
                            <button class="btn download-app-button">Download App</button>
                        </div>

                        <div class="userdetails-box">
                            <h5>Fetched from ABHA</h5>
                            <p>Profile</p>

                            <div class="abha-user-detail">
                                <div class="row detail-row">
                                    <div class="col-md-3">
                                        <label class="label">Full Name</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input value="" readonly></input>
                                    </div>
                                </div>
                                    <div class="row detail-row">
                                    <div class="col-md-3">
                                        <label class="label">Gender</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-3">
                                        <label class="label">DOB</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-3">
                                        <label class="label">Address</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input value="" readonly></input>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="input-group mt-5 abha-address">
                                <div class="row abha-input-wrapper">
                                    <div class="col-md-3">
                                        <label for="abhaAddress">ABHA</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="abhaAddress" placeholder="ABHA Address" />
                                        <span class="abha-suffix pb-3">@abdm</span>
                                        <small>Should have min length 08 - max length 18 char (only ‘.’ and/or ‘_’ are allowed in-between)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="suggestions mt-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Suggestions :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="suggestion-buttons">
                                            <button class="btn mb-3">Input option 1</button><br>
                                            <button class="btn mb-3">Input option 2</button><br>
                                            <button class="btn mb-3">Input option 3</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="btn btn-info w-100 mt-3" id="resendBtn" onclick="startResendTimer()">Continue</button>
                        </div>

                        <div class="certified-by">
                            <img src="{{ asset('public/admin_images/abha/certified-by.png') }}" alt="">
                        </div>
                    </div>
                </div>

                <div class="abha_detail_left" id="step4">
                    <div class="abha-bg">
                        <div class="right-button">
                            <button class="btn login-accuster-button">login eAccuster</button>
                            <button class="btn download-app-button">Download App</button>
                        </div>

                        <div class="userdetails-box">
                            <h5>Patient Details</h5>
                   
                            <div class="abha-user-detail">
                                <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">ABHA Address</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>
                                    <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">ABHA Number</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">Patient Name</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">Gender</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">DOB</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">Mobile Number</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">State</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">District</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>

                                <div class="row detail-row">
                                    <div class="col-md-4">
                                        <label class="label">Address</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label> : </label>
                                    </div>
                                    <div class="col-md-7">
                                        <input value="" readonly></input>
                                    </div>
                                </div>
                            </div>


                            <div class="row abha-down-btn">
                                <div class="col-md-4">
                                    <button class="btn ahba-btn">Download ABHA Card</button>
                                </div>

                                <div class="col-md-4">
                                    <button class="btn ahba-btn">Print ABHA Card</button>
                                </div>

                                <div class="col-md-4">
                                    <button class="btn ahba-btn">Send on Whatsapp</button>
                                </div>
                            </div>
                            
                            <button class="btn btn-info w-100 mt-3 go-home-btn">Go Home</button>
                        </div>

                        <div class="certified-by">
                            <img src="{{ asset('public/admin_images/abha/certified-by.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script src="{{ asset('public/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
</script>
<script src="{{ asset('public/assets/js/main.js') }}"></script>
<script src="{{ asset('public/assets/vendor/sweetalert/js/sweet-alert.js') }}"></script>
<script src="{{ asset('public/assets/vendor/datatable/js/datatables.js') }}"></script>
<script src="{{ asset('public/assets/vendor/toastr/js/toastr.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const steps = ["step1", "step2", "step3", "step4"];
        steps.forEach((step, index) => {
            document.getElementById(step).style.display = index === 0 ? "block" : "none";
        });

        // Continue button click logic for each step
        const step1Continue = document.querySelector('#step1 .continue-button a');
        const step2Continue = document.querySelector('#step2 button.btn.btn-info');
        const step3Continue = document.querySelector('#step3 button.btn.btn-info');
        const useMobileLink = document.getElementById('useMobileLink');

        step1Continue.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default anchor navigation
            goToStep("step2");
        });

        step2Continue.addEventListener('click', function (e) {
            e.preventDefault();
            goToStep("step3");
        });

        step3Continue.addEventListener('click', function (e) {
            e.preventDefault();
            goToStep("step4");
        });
        
        
        useMobileLink.addEventListener('click', function (e) {
            e.preventDefault();
            goToStep("step2");
        });
        

        function goToStep(stepIdToShow) {
            steps.forEach((stepId) => {
                document.getElementById(stepId).style.display = stepId === stepIdToShow ? "block" : "none";
            });
            window.scrollTo(0, 0); // Scroll to top when step changes
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value[0]; //    
                    }
                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus(); //   
                    }
                });

                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace') {
                        this.value = '';
                        if (i > 0) {
                            inputs[i - 1].focus();   
                        }
                    }
                });
            }
        }
        OTPInput();

        const validateBtn = document.getElementById('validateBtn');
        validateBtn.addEventListener('click', function() {
            let otp = '';
            document.querySelectorAll('#otp > input').forEach(input => otp += input.value);
            alert(`Entered OTP: ${otp}`);  
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value[0]; //    
                    }
                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus(); //   
                    }
                });

                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace') {
                        this.value = '';
                        if (i > 0) {
                            inputs[i - 1].focus();   
                        }
                    }
                });
            }
        }

        OTPInput();

        const validateBtn = document.getElementById('validateBtn');
        validateBtn.addEventListener('click', function() {
            let otp = '';
            document.querySelectorAll('#otp > input').forEach(input => otp += input.value);
            alert(`Entered OTP: ${otp}`);  
        });
    });
</script>

<script>
    let timer;
    let countdown = 60; // Set the countdown duration in seconds

    function startResendTimer() {
        // Disable the button during the countdown
        document.getElementById('resendBtn').disabled = true;

        // Start the countdown
        timer = setInterval(updateTimer, 1000);
    }

    function updateTimer() {
        const timerElement = document.getElementById('timer');
        
        if (countdown > 0) {
            timerElement.textContent = `Resend in ${countdown}`;
            countdown--;
        } else {
            // Enable the button when the countdown reaches zero
            document.getElementById('resendBtn').disabled = false;
            timerElement.textContent = '';
            
            // Reset countdown for the next attempt
            countdown = 60;
            
            // Stop the timer
            clearInterval(timer);
        }
    }
</script>
    
</body>
</html>
