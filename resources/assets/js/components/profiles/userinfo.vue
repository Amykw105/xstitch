<template lang="html">
    <div class="container">
      <div class="profile-image-block">
        <img :src="avatar" :alt="username" class="profile-picture"/>
      </div>
      <div class="profile-info-block">
        <p class="profile-name">{{username}}</p>
        <p class="profile-location">{{location}}</p>
        <p class="profile-about">{{about}}</p>
      </div>
    </div>
</template>

<script>
export default {
    props: {
      userslug: '',
        userid: ''
    },
    data(){
        return {
            username: '',
            avatar: '',
            location: '',
            about: ''
        }
    },
    created(){
        this.fetchInfo();
    },
    methods: {
        fetchInfo(){ // Get all Info
          axios.get('/api/' + this.userslug + '/info').then(response => {
              this.username = response.data.userinfo.name;
              this.avatar = response.data.userinfo.avatar;
              this.location = response.data.userdata.location;
              this.about = response.data.userdata.about;
          });
        },
    } // end methods
}
</script>
