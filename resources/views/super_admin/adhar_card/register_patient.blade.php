@extends('super_admin.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section patients mt-3">
    <div class="container">
        <div class="row">
            <div class="form-title d-flex">
                <i class="bi bi-person-fill"></i>
                <h5 class="ps-2 font-weight-bold">Create ABHA</h5>
            </div>
        </div>
        <hr>

        <div class="patient-section">
            <section id="staged-form">
                <ul id="stage-progress">
                    <li class="active-stage">Consent Collection</li>
                    <li>Aadhar Authentication</li>
                    <li>Profile Details</li>
                    <li>Abha Creation</li>
                </ul>
                
                <main>
                    <div id="form-section">
                        <form>
                            <div class="container mt-4">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-2">
                                        <label for="aadhaar1" class="form-label fw-bold">Aadhar Number</label>
                                    </div>
                                    <div class="col-md-6 d-flex gap-2">
                                        <input type="text" maxlength="4" class="form-control aadhaar-input text-center" placeholder="XXXX" id="aadhaar1">
                                        <input type="text" maxlength="4" class="form-control aadhaar-input text-center" placeholder="XXXX" id="aadhaar2">
                                        <input type="text" maxlength="4" class="form-control aadhaar-input text-center" placeholder="XXXX" id="aadhaar3">
                                    </div>
                                </div>

                                <div class="consent-box">
                                    <ul>
                                        <li>
                                            <div class="consent-list-box">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" style="width: 50px;">
                                                <p>I am voluntarily sharing my Aadhaar Number / Virtual ID issued by the Unique Identification Authority of India ("UIDAI"), and my demographic information for the purpose of creating an Ayushman Bharat Health Account number (ABHA number) and Ayushman Bharat Health Account address (ABHA Address"). I authorize NHA to use my Aadhaar number / Virtual ID for performing Aadhaar based authentication with UIDAI as per the provisions of the Aadhaar (Targeted Delivery of Financial and other Subsidies, Benefits and Services) Act, 2016 for the aforesaid purpose. I understand that UIDAI will share my e-KYC details, or response of "Yes" with NHA upon successful authentication.</p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="consent-list-box">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                <p>I consent to usage of my ABHA address and ABHA number for linking of my legacy (past) government health records and those which will be generated during this encounter.</p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="consent-list-box">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                <p>I authorize the sharing of all my health records with healthcare provider(s) for the purpose of providing healthcare services to me during this encounter.</p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="consent-list-box">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                                <p>I consent to the anonymization and subsequent use of my government health records for public health purposes.</p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="consent-list-box">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5">
                                                <p>I <b class="text-decoration-underline">User Name</b> , confirm that I have duly informed and explained the beneficiary of the contents of consent for aforementioned purposes.</p>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="consent-list-box">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6">
                                                <p> I <input type="text" class="form-control" style="width: 210px;height: 20px;" placeholder="Patient Name"> benefiaciary have been explained about the consent as stated above and hereby provide my consent for the aforementioned purposes.
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                        <form>
                            <div class="row" style="justify-content: center;">
                                <div class="container-box-step2">
                                    <h5>Confirm OTP</h5>
                                    <p>OTP sent to Aadhar registered mobile number ending with ******4995</p>

                                    <!-- Step 1 -->
                                    <div class="step-container">
                                        <div class="step-marker">1</div>
                                        <div class="w-100">
                                            <div class="otp-inputs-step2 d-flex" id="otp">
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
                                        <div class="w-100 step-2-label">
                                            <label class="form-label">Add mobile number you want to link with ABHA</label>
                                            <label class="form-label">Phone Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0 pe-0">
                                                    <i class="bi bi-telephone-fill"></i>
                                                </span>
                                                <input type="text" class="form-control m-0 border-start-0" placeholder="+91 xxx xxx xxxx">
                                                <button class="btn btn-success text-white" id="resendBtn" onclick="startResendTimer()" style="margin-left: 10px; border-radius: 5px;">Send Otp</button>
                                            
                                                
                                                <div class="w-100 mt-3">
                                                    <label class="form-label">OTP (One Time Password)</label>
                                                    <div class="otp-inputs-step2 d-flex" id="otp">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form>
                            <div class="user-box">
                                <h5>Fetched from ABHA</h5>
                    
                                <div class="abha-user">
                                    <h6><b>Profile</b></h6>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">Full Name</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>
                                        <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">Gender</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                           <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">DOB</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">Gender</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">Address</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="user-abha-mail">
                                    <div class="mail-input">
                                        <label for="">ABHA</label>
                                        <input type="text" placeholder="ABHA Address"><span>@abdm</span>
                                        <p>Should have min length 08 - max length 18 char (only ‘ . ’ and/or ‘ _ ‘are allowed in-betweeen)</p>
                                    </div>
                                </div>

                                <div class="row user-abha-down-btn">
                                    <div class="user-btn-abha">
                                        <label for=""><p> Suggestions : </p></label>
                                        <button class="btn ahba-btn">Input option 1</button>
                                        <button class="btn ahba-btn">Input option 2</button>
                                        <button class="btn ahba-btn">Input option 3</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form>
                            <div class="user-box">
                                <h5>Patient Details</h5>
                    
                                <div class="abha-user">
                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">ABHA Address</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>
                                        <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">ABHA Number</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                           <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">Patient Name</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">Gender</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">DOB</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">Mobile Number</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">State</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">District</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="row user-detail-row">
                                        <div class="col-md-2">
                                            <label class="label">Address</label>
                                        </div>
                                        <div class="col-md-1">
                                            <label> : </label>
                                        </div>
                                        <div class="col-md-7">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row user-abha-down-btn justify-content-center mt-3" style="text-align: center;">
                                    <div class="user-btn-abha">
                                        <button class="btn ahba-btn">Download ABHA Card</button>
                                        <button class="btn ahba-btn">Print ABHA Card</button>
                                        <button class="btn ahba-btn">Send on Whatsapp</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </main>
                
                <div id="form-navigation">
                    <button class="secondary-btn d-none" id="prev"></button>
                    <button class="btn btn-success text-white" id="next">Submit</button>
                    <button class="btn btn-success" id="save">Submit</button>
                </div>
            </section>
        </div>
    </div>
</section>

<style>
    :root {
        --light-gray: #494949;
        --accent: #4DA17B;
        --dark-bg: #202020;
        --input-bg: #262626;
        --red: #DF2B20;
        --primary-text: #FFFFFF;
        --secondary-text: #9F9F9F;
        --faded-accent: rgba(238, 196, 139, 0.15);
    }

    /* body {
    display: grid;
    place-items: center;
    min-height: 100vh;
    background: #080808;
    color: var(--primary-text);
    } */

    #staged-form {
        /* background: var(--dark-bg); */
        /* max-width: 530px; */
        width: 100%;
        /* padding: 30px 0; */
        display: flex;
        flex-direction: column;
        align-items: center;
        /* border-radius: 10px; */
        /* border: 1px solid var(--faded-accent); */
    }

    #staged-form h2 {
        margin: 0 0 12px 0;
    }


    /* ---------- STAGE PROGRESS ---------- */
    #stage-progress {
        list-style: none;
        width: 105%;
    }

    #stage-progress li {
        float: left;
        width: 24.33%;
        position: relative;
        text-align: center;
        color: var(--secondary-text);
        font-size: 12px;
    }

    #stage-progress li::before {
        display: block;
        content: "";
        height: 32px;
        width: 32px;
        border-radius: 50%;
        margin: 0 auto 5px auto;
        border: 4px solid #CCCCCC;
        background: #CCCCCC;
        transition: border 0.1s ease-in-out 0s, background 0.1s ease-in-out 0s;
    }

    #stage-progress li::after {
        position: absolute;
        content: "";
        width: calc(100% - 40px);
        height: 4px;
        border-radius: 5px;
        background: #CCCCCC;
        left: calc(-50% + 20px);
            top: 14px;
        background: linear-gradient(90deg, var(--accent) 50%, #D9D9D9 50%);
        background-size: 210% 100%;
        background-position: -95% 0;
        transition: background-position 0.3s ease-in-out;
    }

    #stage-progress li:first-child::after {
        content: none;
    }

    #stage-progress li.active-stage::before {
        border-color: #4DA17B;
        background: #4DA17B;
        transition: border 0.1s ease-in-out 0.3s, background 0.1s ease-in-out 0.3s;
    }

    #stage-progress li.active-stage::after {
        background-position: -190% 0;
    }

    #stage-progress li:has(~ .active-stage)::before, #stage-progress li:has(~ .active-stage)::after {
        border-color: #4DA17B;
        background: #4DA17B;
        background-position: -190% 0;
    }


    /* ---------- FORMS ---------- */
    main {
        overflow: hidden;
        margin: 24px 0;
        position: relative;
    }

    form {
        width: 100%;
        padding: 0 24px;
        box-sizing: border-box;
        flex-shrink: 0;
    }

    #form-section {
        display: flex;
        transition: transform 0.3s ease-in-out;
    }

    main::before {
        left: 0;
        width: 24px;
        background: linear-gradient(90deg, var(--dark-bg), rgba(32, 32, 32,0));
    }
    
    main::after {
        right: 0;
        background: linear-gradient(-90deg, var(--dark-bg), rgba(32, 32, 32,0));
    }

    /* ---------- NAVIGATION BUTTONS ---------- */
    #form-navigation button {
        font-size: 14px;
        font-weight: Bold;
        padding: 0.5em 1.5em;
        border-radius: 5px;
        cursor: pointer;
        color: var(--dark-bg);
        position: relative;
    }

    /* .primary-btn {
        background: linear-gradient(90deg, #FDF5EC, #EEC48B, #EEC48B, #947A58);
        background-size: 200% 200%;
        background-position: 100% 0;
        border: none;
        transition: background-position 0.3s ease-in-out;
    }
    .primary-btn:hover {
        background-position: 0 0;
    } */

    .secondary-btn {
        background: linear-gradient(90deg, #FDF5EC, #EEC48B, #EEC48B, #947A58);
        background-size: 200% 200%;
        background-position: 100% 0;
        border: none;
        z-index: 3;
        transition: background-position 0.3s ease-in-out;
    }

    .secondary-btn:hover, .secondary-btn:hover::after{
        background-position: 0 0;
    }

    .secondary-btn::before {
        position: absolute;
        content: "";
        height: calc(100% - 4px);
        width: calc(100% - 4px);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 3px;
        background: var(--dark-bg);
        z-index: -1;
    }

    .secondary-btn::after {
        content: "⟵ Prev Step";
        background: linear-gradient(90deg, #FDF5EC, #EEC48B, #EEC48B, #947A58);
        background-size: 200% 200%;
        background-position: 100% 0;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        transition: background-position 0.3s ease-in-out;
    }

    #prev, #save {
        display: none;
    }



    /* step1 */
    .consent-list-box {
        display: flex;
    }
    .consent-box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .consent-list-box p {
        font-size: 14px;
        letter-spacing: 0;
        font-weight: 400;
    }
    .consent-list-box input {
        margin-right: 10px;
    }
    .consent-list-box input {
        margin-right: 10px;
        background: none !important;
        border-color: #505050 !important;
    }

    /* step2 */
    .container-box-step2 {
        max-width: 670px;
    }
    .container-box-step2 h5{
        font-size: 22px;
        font-weight: 600;
    }
    .otp-inputs-step2 {
        gap: 10px;
    }

    .container-box-step2 .otp-inputs-step2 input {
        width: 40px;
        height: 40px;
        /* color: white; */
        border: 1px solid #9BB1C8;
    }

    .container-box-step2 .step-2-label label{
        font-size: 14px;
        font-weight: 600;
        color: #000000;
    }

    .container-box-step2 span.input-group-text {
        background: white;
    }

    .container-box-step2 .show-section i {
        color: #495057 !important;
    }

    .container-box-step2 #timer {
        color: #FF0000;
        font-size: 15px;
        font-weight: 600;
    }

    .user-box .abha-user {
        background: #EDEDED;
    }

    .user-box .abha-user {
        background: #EDEDED;
        padding: 20px 25px 20px 25px;
        font-size: 15px;
        font-weight: 400;
    }

    .user-abha-mail .mail-input {
        padding: 20px 10px;
    }
    .mail-input p {
        font-size: 13px;
        padding-top: 5px;
    }
    .mail-input span {
        padding-left: 2px;
    }
    .row.user-abha-down-btn {
        padding-left: 10px;
    }
    button.btn.ahba-btn {
        background: #DB3535;
        color: #FFFFFF;
        font-weight: 600;
        font-size: 13px;
    }
    .user-abha-down-btn .ahba-btn {
        gap: 10px;
    }
</style>
@endsection

@section('custom-js')
<script>
const prevBtn = document.querySelector("#prev");
const nextBtn = document.querySelector("#next");
const saveBtn = document.querySelector("#save");
const stageProgress = document.querySelector("#stage-progress");
const formSection = document.querySelector("#form-section");

let currentStage = 0;

const updateForm = (progression) => {
  currentStage += progression;
  for(let i = 0; i < stageProgress.children.length; i++ ){
    if(i === currentStage) {
      stageProgress.children.item(i).classList.add("active-stage");
      continue;
    }
    stageProgress.children.item(i).classList.remove("active-stage");
  }
  
  formSection.style.transform = `translateX(-${currentStage * 100}%)`;
  
if (currentStage === 0) {
  prevBtn.style.display = "none";
  nextBtn.style.display = "inline-block";
  saveBtn.style.display = "none";
} else if (currentStage === stageProgress.children.length - 1) {
  prevBtn.style.display = "inline-block";
  nextBtn.style.display = "none";
  saveBtn.style.display = "inline-block";
} else {
  prevBtn.style.display = "inline-block";
  nextBtn.style.display = "inline-block";
  saveBtn.style.display = "none";
}

}

prevBtn.addEventListener("click", () => updateForm(-1))
nextBtn.addEventListener("click", () => updateForm(+1))
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
@endsection