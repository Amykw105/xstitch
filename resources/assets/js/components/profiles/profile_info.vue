<template>
    <div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="text-center">
                    {{name}}'s Profile
          </div>
        </div>
        <div class="panel-body">
          <center>
              <img :src="avatar" alt="" style="width: 100px;"/>
          </center>
          {{about}}
          <br/><br/>
          {{locations}}
        </div>

      </div>
    </div>
</template>

<script>
export default {
  props: {
      userslug: {
            type: String,
            default: "",
        }
    },
    data() {
        return {
            name : '',
            avatar: '',
            about: '',
            locations: ''
        }
    },
    mounted(){
      this.getInfo();
    },
    methods : {
        getInfo(){
            axios.get('/api/' + this.userslug + '/info')
                .then((response) => {
                    let info = response.data;
                    this.info = info.userbasics;
                    this.name = info.userbasics.name;
                    this.avatar = info.userbasics.avatar;
                    this.about = info.user.about;
                    this.locations = info.user.location;
                })
                .catch(
                    (response) => {
                        console.log('error');
                        console.log(response.data);
                    }
                );
        }
    }
}
</script>
