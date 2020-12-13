<template>
  <div id="app">
    <div class="container">

      <div class="left-side">

        <header>

          <div class="logo-container">
            <div class="logo-image"></div>
            <div class="logo-image-pineapple"></div>
          </div>

          <div class="menu">
            <ul>
              <li><a href="#">About</a></li>
              <li><a href="#">How it works</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>

        </header>

        <div v-if="!thanksMessage" class="content-container">

          <h1>Subscribe to newsletter</h1>

          <div class="text-block">
            Subscribe to our newsletter and get 10% discount on
            pineapple glasses.
          </div>

          <div v-if="errors.length">
              <p v-for="error in errors">{{ error }}</p>
          </div>

          <form method="post" action="http://localhost/api/index.php/" @submit.prevent="checkForm">

            <input type="text"
                   id="email"
                   v-model="email"
                   name="email"
                   placeholder="Type your email address here...">

            <button type="submit">
              <svg width="1.3vw" height="4vh" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3" d="M17.7071 0.2929C17.3166 -0.0976334 16.6834 -0.0976334 16.2929 0.2929C15.9023 0.683403 15.9023 1.31658 16.2929 1.70708L20.5858 5.99999H1C0.447693 5.99999 0 6.44772 0 6.99999C0 7.55227 0.447693 7.99999 1 7.99999H20.5858L16.2929 12.2929C15.9023 12.6834 15.9023 13.3166 16.2929 13.7071C16.6834 14.0976 17.3166 14.0976 17.7071 13.7071L23.7071 7.70708C24.0977 7.31658 24.0977 6.6834 23.7071 6.2929L17.7071 0.2929Z" fill="#131821"/>
              </svg>
            </button>
            <div class="termscheck">
              <input type="checkbox" id="terms_checkbox" v-model="checked">
              <label for="terms_checkbox">I agree to <a href="#">terms of service</a></label>
            </div>
          </form>

          <div class="line">
            <svg width="24.7vw" height="1" viewBox="0 0 400 1" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="24.7vw" height="1"  fill="#E3E3E4"/>
            </svg>
          </div>

          <div class="social-icon">

            <a href="#">
              <div class="icon" id="facebook">
                <span class="icon-ic_facebook"></span>
              </div>
            </a>

            <a href="#">
              <div class="icon" id="instagram">
                <span class="icon-ic-instagram"></span>
              </div>
            </a>

            <a href="#">
              <div class="icon" id="twitter">
                <span class="icon-ic_twitter"></span>
              </div>
            </a>

            <a href="#">
              <div class="icon" id="youtube">
                <span class="icon-ic-youtube"></span>
              </div>
            </a>

          </div>

        </div>

        <div v-if="thanksMessage" class="content-container" id="thanks">

          <img class="cup" src="images/cup.png">
          <h1>Thanks for subscribing!</h1>

          <div class="text-block">
            You have successfully subscriped to our email listing.
            Check your email for the discount code.
          </div>

          <div class="line">
            <svg width="24.7vw" height="1" viewBox="0 0 400 1" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="24.7vw" height="1" fill="#E3E3E4"/>
            </svg>
          </div>

          <div class="social-icon">

            <a href="#">
              <div class="icon" id="facebook">
                <span class="icon-ic_facebook"></span>
              </div>
            </a>

            <a href="#">
              <div class="icon" id="instagram">
                <span class="icon-ic-instagram"></span>
              </div>
            </a>

            <a href="#">
              <div class="icon" id="twitter">
                <span class="icon-ic_twitter"></span>
              </div>
            </a>

            <a href="#">
              <div class="icon" id="youtube">
                <span class="icon-ic-youtube"></span>
              </div>
            </a>

          </div>

      </div>

    </div>

      <div class="right-side"></div>
  </div>
  </div>
</template>

<script>

    import axios from 'axios';

    export default {
       name: 'home',
        data() {
           return {
               errors: [],
               email: null,
               checked: false,
               thanksMessage: false,
           }
        },
       methods: {
           checkForm: function(e) {
               this.errors = [];

               if (!this.email) {
                   this.errors.push('Please enter your email address.');
               } else if (!this.validEmail(this.email)) {
                   this.errors.push('Please provide a valid e-mail address.');
               } else if (this.isColombia(this.email)) {
                   this.errors.push('We are not accepting subscriptions from Columbia.');
               } else if(!this.checked) {
                   this.errors.push('You must accept the terms and conditions.');
               } else {
                   fetch('http://localhost/api/addmail.php/', {
                       method: 'post',
                       headers: {
                           'Accept': 'application/json',
                           'Content-Type': 'application/json'
                       },
                       body: JSON.stringify({
                           email: this.email,
                           checked: this.checked
                       })
                   }).then(response => {
                           if (!response.ok) console.log("fetch 1 error " + response.statusText);
                           return response.json(); }
                       ).then((res) => {
                           if(res.message === 'Email is added.') {
                               this.thanksMessage = true;
                           } else {
                               this.errors.push(res.message);
                           }
                           console.log(res.message);
                           console.log(res.mail);
                   }).catch((error) => {
                       console.log('Post Error := ' + error)
                   });

               }
           },
           validEmail: function (email) {
               let regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
               return regex.test(email);
           },
           isColombia: function(email) {
               let regex = /\.co$/gi;
               return regex.test(email);
           }
       },
    }


</script>

<style>

</style>
