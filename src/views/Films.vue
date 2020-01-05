<template>

  <v-container class="my-5">
    <v-menu offset-y v-model="showMenu" style="max-width: 400px">
       <template v-slot:activator="{ on }">
        <v-text-field
            hide-details
            label="Search"
            prepend-inner-icon="mdi-magnify"
            solo-inverted
            append-icon="mdi-dots-vertical"
            v-model="query"
            @input="search()"
            @click:append="showMenu=!showMenu"
          >
          </v-text-field>
       </template>
        <v-list>
          <v-list-item v-for="(item, index) in filters" :key="item.id" @click="sortFilms(index)" >
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

    <v-layout row wrap>

      <v-flex xs12 sm4 md3 lg2 v-for="film in films_show" :key="film.id">
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
              <v-rating
                v-model="film.rating_avg"
                color="purple"
                background-color="purple lighten-3"
                dense
                half-increments
                readonly
                size="20"
              ></v-rating>
              <div class="grey--text ml-4">{{ film.rating_avg_short }} ({{ film.rating_count }})</div>
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
    <v-btn block @click="loadMore()" v-if="query=='' && showButton" style="margin-top: 15px">LOAD MORE</v-btn>
  </v-container>
</template>

<script>

export default {
  name: 'Films',
  data: () => ({
    showMenu: false,
    filters: [
        { title: 'Sort by ascendent Bayesian ranking', id: 0 },
        { title: 'Sort by ascendent average rating', id: 1 },
        { title: 'Sort by ascendent rating count', id: 2 },
        { title: 'Sort by ascendent alphabetic order', id: 3 },
        { title: 'Sort by ascendent premiere date', id: 4 },
        { title: 'Sort by descendent Bayesian ranking', id: 5 },
        { title: 'Sort by descendent average rating', id: 6 },
        { title: 'Sort by descendent rating count', id: 7 },
        { title: 'Sort by descendent alphabetic order', id: 8 },
        { title: 'Sort by descendent premiere date', id: 9 },
      ],

    showButton: false,
    show_description: false,
    show_description_id: null,
    query: "",

    films_all: [],
    films_show: []
  }),
  async mounted() {
    let films = await fetch("http://localhost/api/films.php");
    films = await films.json();
    // Bayesian order by default
    this.films_all = films.sort((a, b) => parseFloat(a.rating_bayesian) - parseFloat(b.rating_bayesian));
    for (let i in this.films_all) {
      this.films_all[i].title = this.films_all[i].title.substring(0, 23)
      if (i < 44) this.films_show.push(this.films_all[i])
    }
    await new Promise(resolve => setTimeout(resolve, 1000));
    this.showButton = true
  },
  methods: {
    getImgUrl(image) {
      try {
        return require('../images/films/' + image)
      } catch (e) {
          return require("../images/placeholders/placehoder_film.jpg")
      }
    },
    async search() {
      this.films_show = []
      let count = 0
      for (let film of this.films_all) {
        if (film.title.toLowerCase().indexOf(this.query) != -1) {
          if (count < 18) {
            this.films_show.push(film)
            count ++
          }
        }
      }
    },
    async loadMore() {
      this.films_show.length
      let count = 0
      for (let i in this.films_all) {
        if (i > this.films_show.length && count < 44) {
          this.films_show.push(this.films_all[i])
          count++
        }
      }
    },
    async test(test) {
     // ! showMenu,alert('fesf')
     // eslint-disable-next-line no-console
     console.log(test)
    },
    async sortFilms(order_id) {
      switch(order_id) {
        // Bayesian
        case 0: 
          this.films_all.sort((a, b) => parseFloat(a.rating_bayesian) - parseFloat(b.rating_bayesian));
          break;
        // Average
        case 1:
          this.films_all.sort((a, b) => parseFloat(a.rating_avg) - parseFloat(b.rating_avg)).reverse();
          break;
        // Count
        case 2:
          this.films_all.sort((a, b) => parseFloat(a.rating_count) - parseFloat(b.rating_count)).reverse();
          break;
        // Alphabetic
        case 3:
          this.films_all.sort((a, b) => a.title.localeCompare(b.title));
          break;
        // Date
        case 4:
          this.films_all.sort((a, b) => new Date(a.date) - new Date(b.date));
          break;
        // Bayesian reversed
        case 5:
          this.films_all.sort((a, b) => parseFloat(a.rating_bayesian) - parseFloat(b.rating_bayesian)).reverse();
          break;
        // Average reversed
        case 6:
          this.films_all.sort((a, b) => parseFloat(a.rating_avg) - parseFloat(b.rating_avg));
          break;
        // Count reversed
        case 7:
           this.films_all.sort((a, b) => parseFloat(a.rating_count) - parseFloat(b.rating_count));
          break;
        // Alphabetic reversed
        case 8:
          this.films_all.sort((a, b) => a.title.localeCompare(b.title)).reverse();
          break;
        // Date reversed
        case 9:
          this.films_all.sort((a, b) => new Date(a.date) - new Date(b.date)).reverse();
          break;
      }
      this.films_show = []
      for (let i in this.films_all) {
        if (i < 44) this.films_show.push(this.films_all[i])
      }
      //
    },
  }
};
</script>

<style>
.v-input__icon--prepend-inner .v-icon { 
    color: rgb(255, 255, 255);
}
</style>