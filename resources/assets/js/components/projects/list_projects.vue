<template>
    <div>

        <div class="text-center">

          <div v-if="projects.length > 0">
            <li v-for="project in projects">
            <a :href="'/profile/' + userslug + '/' + project.slug">{{project.name}}</a>
            </li>
          </div>
          <div v-else>
            No active projects
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
            projects : [],
        }
    },
    created(){
        this.getProjects();
    },
    methods : {
        getProjects(){
            axios.get('/api/' + this.userslug + '/projects_list')
                .then((response) => {
                    let projects = response.data;
                    this.projects = projects.projects;
                    console.log(response.data.projects);
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
