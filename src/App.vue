<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
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
        <v-list-item link to='/account'>
          <v-list-item-action>
            <v-icon>mdi-account-circle</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Account</v-list-item-title>
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
      <v-toolbar-title>
        <v-icon>mdi-video-vintage</v-icon>
        Film Rating Recommendation 
      </v-toolbar-title>
      
      <v-col class="text-right font-weight-medium">
        Login
        <v-btn text icon @click.stop="dialog = true">
          <v-icon>mdi-login</v-icon>
        </v-btn>
      </v-col>
      
    </v-app-bar>

    <v-content>
      <v-dialog v-model="dialog" max-width="600px">
      <v-card>
        <v-card-title>
          <v-icon>mdi-account</v-icon>
          <span class="headline ml-3">Login</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Name *" required clearable></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password *" type="password" required counter></v-text-field>
              </v-col>

            </v-row>
          </v-container>
          <small>* required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="dialog = false, dialog_register = true">Register</v-btn>
          <v-btn color="blue darken-1" text @click="dialog = false">Login</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog_register" max-width="600px">
      <v-card>
        <v-card-title>
          <v-icon>mdi-account-plus</v-icon>
          <span class="headline  ml-3">Register</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="Name *" required clearable></v-text-field>
              </v-col>
              <v-col cols="12" style="margin-bottom: -10px">
                <v-slider
                  color="purple"
                  label="Age *"
                  min="1"
                  max="120"
                  required
                ></v-slider>
              </v-col>
              <v-col cols="12">
                <v-select
                  :items="genders"
                  color="purple"
                  label="Gender *"
                  required
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Occupation *" required clearable></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password *" type="password" required counter></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Repeat password *" type="password" required counter></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>* required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog_register = false">CLOSE</v-btn>
          <v-btn color="blue darken-1" text @click="dialog_register = false">REGISTER</v-btn>
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
  </v-app>
</template>

<script>

export default {
  name: 'App',
    props: {
      source: String,
    },

    data: () => ({
      drawer: null,
      dialog: false,
      dialog_register: false,
      genders: ['Male', 'Female']
    }),
    created () {
      this.$vuetify.theme.dark = true
    },
};
</script>
