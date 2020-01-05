<template>
  <v-app>
    <v-navigation-drawer
      clipped
      floating
      mini-variant
      permanent
      app
      overflow
    >
      <v-list dense> 
        <v-list-item link to='/'>
          <v-list-item-action>
            <v-icon>mdi-library-video</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Films</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link to='/recommended'>
          <v-list-item-action>
            <v-icon>mdi-lightbulb-on</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Recommended</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link to='/profile'>
          <v-list-item-action>
            <v-icon>mdi-account-circle</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Profile</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link to='/about'>
          <v-list-item-action>
            <v-icon>mdi-information-outline</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>About</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      color="black"
      clipped-left
      dark
    >
      <v-toolbar-title style="text-decoration: none;">
        <router-link text to="/" style="text-decoration:none;color:white">
          <v-icon>mdi-video-vintage</v-icon>
          Film Rating Recommendation 
        </router-link>
      </v-toolbar-title>
      
      <v-col class="text-right font-weight-medium">
        <v-btn text icon @click.stop="login_form_show=true" style="margin-right:20px">
          <div style="margin-right:10px">
            Login
          </div>
          <v-icon>mdi-login</v-icon>
        </v-btn>
      </v-col>
    </v-app-bar>

    <v-content>
      <v-dialog v-model="login_form_show" max-width="600px">
      <v-card>
        <v-card-title>
          <v-icon>mdi-account</v-icon>
          <span class="headline ml-3">Login</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Name *" required clearable v-model="login_form_name"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password *" type="password" required counter v-model="login_form_password"></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>* required field</small>
        </v-card-text>
        <v-card-actions>
          
          <v-btn color="blue darken-1" text @click="login_form_show=false">Close</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="login_form_show=false, register_form_show=true">Register</v-btn>
          <v-btn color="blue darken-1" text @click="login_form_show=false, login()">Login</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="register_form_show" max-width="600px">
      <v-card>
        <v-card-title>
          <v-icon>mdi-account-plus</v-icon>
          <span class="headline  ml-3">Register</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Name *" required clearable v-model="register_form_name"></v-text-field>
              </v-col>
              <v-col cols="12" style="margin-bottom: -10px">
                <v-slider
                  color="purple"
                  label="Age *"
                  min="1"
                  max="120"
                  required
                  thumb-label="always"
                  v-model="register_form_age"
                ></v-slider>
              </v-col>
              <v-col cols="12">
                <v-select
                  :items="genders"
                  color="purple"
                  label="Gender *"
                  required
                  v-model="register_form_gender"
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-select
                  :items="occupations"
                  color="purple"
                  label="Occupation *"
                  required
                  v-model="register_form_occupation"
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password *" type="password" required counter v-model="register_form_password1"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Repeat password *" type="password" required counter v-model="register_form_password2"></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>* required field</small>
        </v-card-text>
        <v-card-actions>          
          <v-btn color="blue darken-1" text @click="register_form_show=false">CLOSE</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="register_form_show=false, register()">REGISTER</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
      <router-view/>
    </v-content>
    
    <v-footer
      color="magenta"
      app
    >
      <span class="white--text">&copy; Ignacio & José 2020</span>
    </v-footer>
    <v-snackbar
      v-model="snackbar_show"
      :color="snackbar_color"
      top
    >
    <v-icon>{{ snackbar_icon }}</v-icon> 
      {{ snackbar_text }}
    </v-snackbar>
  </v-app>
</template>

<script>
// eslint-disable-next-line no-console

export default {
  name: 'App',
    props: {
      source: String,
    },
    data: () => ({
      // Javascript can't watch for object properties changes
      // thats why objects are not used here with two way binding
      login_form_show: false,   
      login_form_name: null,
      login_form_password: null,  

      register_form_show: false,
      register_form_name: null,
      register_form_age: null,
      register_form_gender: null,
      register_form_occupation: null,
      register_form_password1: null,
      register_form_password2: null,

      snackbar_show: false,
      snackbar_color: null,
      snackbar_text: null,
      snackbar_icon: null,

      genders: ['Male', 'Female'],
      occupations: ['administrator','artist','doctor','educator','engineer','entertainment','executive','healthcare','homemaker','lawyer','librarian','marketing','none','other','programmer','retired','salesman','scientist','student','technician','writer']
      
    }),
    created () {
      this.$vuetify.theme.dark = true
    },
    methods: {
      async login() {
        let res = await fetch("http://localhost/api/login.php", {
        method: "POST",
        credentials: 'include',
        body: JSON.stringify({
          name: this.login_form_name,
          password: this.login_form_password
        }),
      });
      res = await res.json();
      if (res.status == true) {
        this.snackbar_color = "success";
        this.snackbar_text = "Success: you are now logged in."
        this.snackbar_icon = "mdi-check"
      } else {
        this.snackbar_color = "error";
        this.snackbar_text = "Error: invalid name or password."
        this.snackbar_icon = "mdi-alert-circle"
      }
      this.snackbar_show = true;
    }, async register() {
        let res = await fetch("http://localhost/api/register.php", {
        method: "POST",
        body: JSON.stringify({
          name: this.register_form_name,
          age: this.register_form_age,
          gender: this.register_form_gender,
          occupation: this.register_form_occupation,
          password1: this.register_form_password1,
          password2: this.register_form_password2
        })
      });
      res = await res.json();
      if (res.status == true) {
        this.snackbar_color = "success";
        this.snackbar_text = "Register success: now you can login with your account."
        this.snackbar_icon = "mdi-check"
      } else {
        this.snackbar_color = "error";
        this.snackbar_text = "Error: there are missing fields in the register form."
        this.snackbar_icon = "mdi-alert-circle"
      }
      this.snackbar_show = true;
    }
  }
};
</script>
