<template>
  <div class="router">
    <h1 class="header">Todo  {{ count }} / {{ countDone }}</h1>
    <div class="container">
      <div class="container col-4">
        <form class="form">
          <div class="col-auto input-col">
            <input
              type="text"
              v-model="todo"
              class="form-control input"
              placeholder="Enter todo item..."
            />
          </div>
          <div class="col-auto">
            <button type="button" @click="addTodo()" class="form-control">ADD</button>
          </div>
        </form>
        <ul>
         <template v-for="(item, index) in todos" :key="item.name">
            <li>
              <span @click="setDone(item.name)" :class="{'done': item.done === true}">{{ item.name }}</span>
              <button @click="deleteTodo(item, index)" class="delete">X</button>
            </li>
         </template>
        </ul>
      </div>
    </div>
  </div>
</template>


<script>
import { ref } from 'vue'

export default {
  setup () {
    let todos = ref([])
    let todo = ref("")
    let count = ref(0)
    let countDone = ref(0)

    //add todo
    const addTodo = () => {
      todos.value.push({name: todo.value, done: false})
      todo.value = ''
      count.value++
    }

    //marked finished
    const setDone = (name) => {
      todos.value.forEach(item => {
        if(name === item.name){
          item.done = ! item.done
          item.done === true ? countDone.value++ : countDone.value--
        }
      });
    }

    //delete todo
    const deleteTodo = async(todo, index) => {
      todos.value  = todos.value.filter(item => item.name !== todo.name)
      // todos.splice(index, 1) //only for dom not todos array
      count.value--
      todo.done === true ? countDone.value-- : 0
    }
    return {
      todos,
      todo,
      addTodo,
      setDone,
      deleteTodo,
      count,
      countDone
    }
  }
}
</script>

