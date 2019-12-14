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
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-library-video</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Films</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-account-circle</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Account</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
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
        <v-icon>mdi-video-vintage </v-icon>
        Film Rating Recommendation
        </v-toolbar-title>
    </v-app-bar>

    <v-content>
      
    </v-content>
    <v-footer
      color="magenta"
      app
    >
      <span class="white--text">&copy; Universidad Politécnica de Cartagena 2020</span>
    </v-footer>
  </v-app>
</template>

<script>
  export default {
    name: 'Layout',
    props: {
      source: String,
    },

    data: () => ({
      drawer: null,
    }),
    created () {
      this.$vuetify.theme.dark = true
    },
  }
</script>