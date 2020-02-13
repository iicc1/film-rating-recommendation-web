<template>
  <v-container class="my-5">
    <v-card>
      <v-card-title>
        <v-icon>mdi-account-edit</v-icon>
        <span class="headline  ml-3">Edit profile: {{ profile_form_name }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
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
              <v-col cols="12">
                <v-avatar size=150>
                  <v-img :src="'http://labit601.upct.es/~ai23/video/img/' + profile_form_pic"></v-img>
                </v-avatar>
                <v-file-input
                  :rules="rules"
                  accept="image/png, image/jpeg"
                  placeholder="Upload profile photo"
                  prepend-icon="mdi-camera"
                  style="max-width: 300px"
                  chips
                  show-size
                  v-model="profile_form_pic_file"
                ></v-file-input>
              </v-col>
              <v-col cols="12">
                <v-btn block @click="update(),upload()">Update profile</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
      </v-card>

      <v-snackbar
        v-model="snackbar_show"
        color="success"
        top
      >
        <v-icon>mdi-check</v-icon> 
          Profile updated succesfully
      </v-snackbar>

  </v-container>
</template>

<script>
  export default {
    name: 'Profile',
    data: () => ({
      snackbar_show: false,
      // File input size rule
      rules: [
        value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!',
      ],
      // Profile variables
      profile_form_name: null,
      profile_form_age: null,
      profile_form_gender: null,
      profile_form_occupation: null,
      profile_form_password1: null,
      profile_form_password2: null,
      profile_form_pic: null,
      profile_form_pic_file: null,
      // Fixed selection of genders & occupations
      genders: ['Male', 'Female'],
      occupations: ['administrator','artist','doctor','educator','engineer','entertainment','executive','healthcare','homemaker','lawyer','librarian','marketing','none','other','programmer','retired','salesman','scientist','student','technician','writer']
    }),
    // Function called when the virtual DOM has been mounted
    async mounted() {
      let res = await fetch("http://localhost/api/profile.php", {
          credentials: 'include'
      })
      res = await res.json();
      this.profile_form_name = res.name;
      this.profile_form_age = res.edad;
      this.profile_form_gender = res.sex;
      this.profile_form_occupation = res.ocupacion;
      this.profile_form_pic = res.pic;
    },
    methods: {
      // Updates user data except its name
      async update() {
        await fetch("http://localhost/api/update.php", {
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
        this.snackbar_show = true
      },
      // Upload image as multipart/form-data encoding type 
      async upload() {
        if (this.profile_form_pic_file != null) {
          let formData = new FormData();
          formData.append('image', this.profile_form_pic_file, this.profile_form_pic_file.name);
          await fetch("http://localhost/api/upload.php", {
            method: "POST",
            credentials: 'include',
            body: formData
          })
        }
      },
      // Get user profile image
      getImgUrl(image) {
        try {
          return require('../images/profiles/' + image)
        } catch (e) {
            e.name
        }
      }
    }
  }
  
</script>