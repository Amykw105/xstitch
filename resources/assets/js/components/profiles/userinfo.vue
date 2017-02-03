<template lang="html">
    <div>
      <h3>{{username}}</h3>
      {{avatar}}<br/>
      {{location}}<br/>
      {{about}}
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
