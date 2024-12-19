import { useState } from "react"

export default function Index() {
  const [data, setData] = useState("")

  const [todos, setTodos] = useState([])
  const [count, setCount] = useState(0)
  const [completedCount, setCompletedCount] = useState(0)

  //add todo
  const addTodo = (e) => {
    e.preventDefault()
    setTodos([...todos, {task:data, completed: false}])
    setCount(count+1)
    setData("")
  }

  //set completed
  const setCompleted = (todo) => {
    todo.completed =! todo.completed
    const newTodos = todos.map(item => item.task === todo.task ? {...item, completed: todo.completed}: item)
    setTodos(newTodos)
    todo.completed === true ? setCompletedCount(completedCount+1) : setCompletedCount(completedCount-1)
  }
  
  //delete todo
  const deleteTodo = (todo) => {
    const newTodos = todos.filter(item => item.task !== todo.task)
    setTodos(newTodos)
    if(todo.completed === true){
      setCompletedCount(completedCount-1)
    }
    setCount(count-1)
  }

  return (
    <>
      <h1 className="header">React Todo List / {count} / {completedCount}</h1>
      <div className="container col-4">
        <form onSubmit={ addTodo} className="form">
          <div className="col-auto input-col">
            <input type="text" onChange={(e) => setData(e.target.value)} value={data} className="form-control" placeholder="Add todo..." />
          </div>
          <div className="col-auto">
            <button type="submit" className="btn btn-primary">Add Todo</button>
          </div>
        </form>
          <ul>
            {todos.map(item => (
              <li key={item.task}>
                <span  onClick={() => setCompleted(item)}>{item.task}</span>
                <div>
                  {item.completed === true ? <span className={"material-symbols-outlined check"}>check</span> : ""}
                  <button onClick={() => deleteTodo(item)} className="material-symbols-outlined delete">delete_forever</button>
                </div>
              </li>
            ))}
          </ul>
      </div>
    </>
  )
}
