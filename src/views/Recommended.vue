<template>
  <v-container class="my-5">
    <h1 style="margin-top:10px;margin-bottom:20px;color:#E0E0E0" class="text-center font-weight-bold">
      According to your interests, you may like this films
    </h1>
    <v-layout row wrap>
      <v-flex xs12 sm4 md3 lg2 v-for="film in films" :key="film.id">
        <v-card raised class="text-xs-center ma-3">
          <router-link :to="'/film?id=' + film.id">
            <v-img :src="getImgUrl(film.url_pic)" height="200px"></v-img>
          </router-link>

          <v-card-title>
            <div class="title font-weight-medium">{{ film.title }}</div>
          </v-card-title>
          <v-card-subtitle>
            {{ film.genre }}
          </v-card-subtitle>
           <v-card-text>
            <v-row align="center" class="mx-0">
            </v-row>
          </v-card-text>

          <v-card-actions>
            <v-btn color="grey lighten-3" text link :href="film.url_imdb" target="_blank">
              IMDB
            </v-btn>
            <router-link :to="'/film?id=' + film.id">
              <v-btn color="grey lighten-3" text>VIEW</v-btn>
            </router-link>
            <v-spacer></v-spacer>
            <v-btn icon @click="show_description=!show_description; show_description_id=film.id">
              <v-icon color="purple">{{ show_description && show_description_id==film.id ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
            </v-btn>
          </v-card-actions>
          <v-expand-transition>
            <div v-show="show_description && show_description_id==film.id">
              <v-divider></v-divider>
              <v-card-text>
                {{ film.desc }}
                <br/><br/>
                Premiere: {{ film.date }}
              </v-card-text>
            </div>
          </v-expand-transition>
        </v-card>
     </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'Films',
  data: () => ({
    films: [],
    show_description: false,
    show_description_id: null,
  }),
  // Function called when the virtual DOM has been mounted
  async mounted() {
    let films = await fetch("http://localhost/api/recommended.php", {
      credentials: 'include'
    });
    this.films = await films.json();
    for (let i in this.films) {
      // Removes the exceed of characters in long titles
      this.films[i].title = this.films[i].title.substring(0, 20)
    }
  },
  methods: {
    // Real time search
    async search() {
      
    },
    // Gets cover image
    getImgUrl(image) {
      try {
        return require('../images/films/' + image)
      } catch (e) {
          return require("../images/placeholders/placehoder_film.jpg")
      }
    },
  }
};
</script>

<style>

</style>