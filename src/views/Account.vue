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
  

  </v-container>
</template>

<script>
  export default {
    data: () => ({
      rules: [
        value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!',
      ],
    }),
  }
</script>