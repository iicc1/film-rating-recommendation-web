<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      clipped="true"
      floating="true"
      mini-variant="true"
      permanent=true
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
      clipped-left="true"
      dark
    >
      <v-toolbar-title>
        <v-icon>mdi-video-vintage</v-icon>
        Film Rating Recommendation 
      </v-toolbar-title>
      
      <v-col class="text-right font-weight-medium">
        Login / Register
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
                <v-text-field label="Username*" required clearable></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password*" type="password" required counter></v-text-field>
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
                <v-text-field label="Username*" required clearable></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Password*" type="password" required counter></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Repeat password*" type="password" required counter></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>* required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog_register = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="dialog_register = false">Register</v-btn>
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
    }),
    created () {
      this.$vuetify.theme.dark = true
    },
};
</script>
