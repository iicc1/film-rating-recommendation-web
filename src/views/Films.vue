<template>

  <v-container class="my-5">
    <v-text-field
        hide-details
        label="Search"
        prepend-inner-icon="mdi-magnify"
        solo-inverted
        append-icon="mdi-dots-vertical"
        v-model="query"
        @input="search()"
      >
      </v-text-field>

    <v-layout row wrap>
      

      <v-flex xs12 sm4 md3 lg2 v-for="film in films_show" :key="film.id">
        <v-card raised class="text-xs-center ma-3">
          <router-link :to="'/film?id=' + film.id">
            <v-img :src="getImgUrl(film.url_pic)" height="200px"></v-img>
          </router-link>

          <v-card-title>
            {{ film.title }}
          </v-card-title>
          <v-card-subtitle>
            <br>
            <v-row>
              <v-col style="margin: 8px">
                {{ rating }}
            </v-col>
              <v-col>
              <v-rating
                v-model="rating"
                background-color="purple lighten-3"
                color="purple"
                half-increments
                hover
                size="20"
              ></v-rating>
            </v-col>
            </v-row>
          </v-card-subtitle>

          <v-card-actions>
            <v-btn text>Explore</v-btn>
            <v-btn color="purple" text link :href="film.url_imdb" target="_blank">
              IMDB
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn icon @click="show_description=!show_description; show_description_id=film.id">
              <v-icon>{{ show_description && show_description_id==film.id ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
            </v-btn>

          </v-card-actions>
          <v-expand-transition>
            <div v-show="show_description && show_description_id==film.id">
              <v-divider></v-divider>
              <v-card-text>
                {{ film.desc }}
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

 // async function getFilms(query) {
  //  let films = await fetch("http://localhost/api/films.php?query=" + encodeURIComponent(query));
   // films = await films.json();
  //for (let i in films) {
    //this.films[i].title = this.films[i].title.replace(/\(\d+\)/g, '')
  //  films[i].title = films[i].title.substring(0, 23)
  //}
  //    return films
 // }

export default {
  name: 'Films',
  data: () => ({
    show_description: false,
    show_description_id: null,
    query: "",

    rating: 4.5,

    films_all: [],
    films_show: []
  }),
  async mounted () {
    //this.films_all = await getFilms("")
    let films = await fetch("http://localhost/api/films.php");
    films = await films.json();
    this.films_all = films;
    for (let i in this.films_all) {
      this.films_all[i].title = this.films_all[i].title.substring(0, 23)
      if (i < 50) this.films_show.push(this.films_all[i])
    } 
  },
  methods: {
    getImgUrl(image) {
      try {
        return require('../images/films/' + image)
      } catch (e) {
          return require("../images/placeholders/placehoder_film.jpg")
      }
    },
    async search(test) {
      // eslint-disable-next-line no-console
      console.log(test)
      this.films_show = []
      let count = 0
      for (let film of this.films_all) {
        if (film.title.toLowerCase().indexOf(this.query) != -1) {
          // eslint-disable-next-line no-console
          if (count < 50) {
            this.films_show.push(film)
            count ++
          }
        }
      }
    }
  }
};
</script>