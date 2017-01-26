<template>
    <div>
        <div class="text-center">

        <li v-for="status in statuses">
                {{status.description}}
        </li>
        </div>
    </div>
</template>

<script>
export default {
  props: {
      userslug: {
            type: String,
            default: "",
        },
      projectslug: {
            default: "",
        }
    },
    data() {
        return {
            statuses : [],
        }
    },
    created(){
        this.getStatuses();
    },
    methods : {
        getStatuses(){
            axios.get('/api/' + this.userslug + '/' + this.projectslug)
                .then((response) => {
                    let statuses = response.data;
                    this.statuses = statuses.statuses;
                    console.log(response.data.statuses);
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
