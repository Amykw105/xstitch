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
        http    :   {
            headers: {
                'X-CSRF-Token': $('#token').attr('content')
            }
        },
    data() {
        return {
            projects : [],
            newProject: {
            			userid: '',
            			name: '',
            			description: '',
            			source: '',
                  slug: '',
            		},
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
                //    console.log(response.data.projects);
                })
                .catch(
                    (response) => {
                        console.log('error');
                        console.log(response.data);
                    }
                );
        }, // end getProject
        // AddNewProject: function () {
    		// 	// User input
    		// 	var project = this.newProject
        //
    		// 	// Clear form input
    		// 	this.newProject = { name:'new project', description:'a new project has been created', projectslug: 'new-project', user_id:'6' }
        //   //console.log('/api/' + this.userslug + '/' + this.newProject.projectslug);
    		// 	// Send post request
    		// 	axios.post('/api/' + this.userslug,
        //     project
        //   )
        //   .then(function (response) {
        //       console.log(response);
        //     })
        //     .catch(function (error) {
        //       console.log(error);
        //     });
        //
        //
    		// 	// Reload page
    		// 	this.getProjects()
        //
    		// }, // end AddNewProject
        AddNewProject: function () {
          // User input
          var project = this.newProject

          // Clear form input
          this.newProject = {userid: '',
          name: '',
          description: '',
          source: '',
          slug: '',}

          // Send post request
          this.$http.post('/api/' + this.userslug, project)

          // Reload page
          this.getProjects()

        }
    } // end of methods
}
</script>
