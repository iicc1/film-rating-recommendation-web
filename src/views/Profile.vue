<template>
  <v-container class="my-5">
      <v-avatar size=150>
        <img
          src="https://pbs.twimg.com/profile_images/378800000599632036/394ee9635551e26c0c3b2033ab8dbea1_400x400.png"
          alt="upct"
        >
      </v-avatar>


      <v-file-input
      :rules="rules"
      accept="image/png, image/jpeg, image/bmp"
      placeholder="Upload profile photo"
      prepend-icon="mdi-camera"
      style="max-width: 300px"
      
      ></v-file-input>
      <v-btn>
        Update photo
      </v-btn>

      <v-card>
        <v-card-title>
          <v-icon>mdi-account-edit</v-icon>
          <span class="headline  ml-3">Edit profile</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Name *" clearable v-model="profile_form_name"></v-text-field>
              </v-col>
              <v-col cols="12" style="margin-bottom: -10px">
                <v-slider
                  color="purple"
                  label="Age"
                  min="1"
                  max="120"
                  thumb-label="always"
                  v-model="profile_form_age"
                ></v-slider>
              </v-col>
              <v-col cols="12">
                <v-select
                  :items="genders"
                  color="purple"
                  label="Gender"
                  v-model="profile_form_gender"
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-select
                  :items="occupations"
                  color="purple"
                  label="Occupation"
                  v-model="profile_form_occupation"
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-text-field label="New password" type="password" counter v-model="profile_form_password1"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Repeat new password" type="password" counter v-model="profile_form_password2"></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="update()">Update profile</v-btn>
        </v-card-actions>
      </v-card>
  

  </v-container>
</template>

<script>
  export default {
    data: () => ({
      rules: [
        value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!',
      ],
      profile_form_name: null,
      profile_form_age: null,
      profile_form_gender: null,
      profile_form_occupation: null,
      profile_form_password1: null,
      profile_form_password2: null,
      profile_form_pic: null,
      genders: ['Male', 'Female'],
      occupations: ['administrator','artist','doctor','educator','engineer','entertainment','executive','healthcare','homemaker','lawyer','librarian','marketing','none','other','programmer','retired','salesman','scientist','student','technician','writer']
    }),
    created () {
      this.$vuetify.theme.dark = true
    },
    async mounted () {
      let res = await fetch("http://localhost/api/profile.php", {
          credentials: 'include'
        })
        res = await res.json();
        // eslint-disable-next-line no-console
        console.log(res)
        this.profile_form_name = res.name;
        this.profile_form_age = res.edad;
        this.profile_form_gender = res.sex;
        this.profile_form_occupation = res.ocupacion;
        this.profile_form_pic = res.pic;
    },
    methods: {
      async update() {
        let res = await fetch("http://localhost/api/update.php", {
          method: "POST",
          credentials: 'include',
          body: JSON.stringify({
            pic: this.profile_form_pic,
            age: this.profile_form_age,
            gender: this.profile_form_gender,
            occupation: this.profile_form_occupation,
            password1: this.profile_form_password1,
            password2: this.profile_form_password2
          })
        })
        res = await res.json();
        // eslint-disable-next-line no-console
        console.log(res)
      }
    }
  }
  
</script>