<template>
  <div>
      <ul>
        <li v-for="post in posts" :key="post.slug">
          <div>TITOLO: {{post.title}}</div>
          <div>CONTENUTO: {{post.content}}</div>
          <div v-if="post.category">CATEGORIA: {{post.category.name}}</div>
          <ul v-if="post.tags">
            TAG: <li v-for="tag in post.tags" :key="tag.slug">{{tag.name}}</li>
          </ul>

          <router-link :to="{ name: 'single-post', params: { slug: post.slug } }">Visualizza il post</router-link>
        </li>
      </ul>
  </div>
</template>

<script>
export default {
    name: "Posts",
    data() {
      return {
        posts: [],
      };
    },
    created(){
        axios
        .get("/api/posts")
        .then((apirisp)=>{
            this.posts= apirisp.data;
            console.log(this.posts);
        })
    }
}
</script>

<style scoped>
ul{
    list-style: none;
  }
  li{
    margin-bottom: 20px;
  }
</style>