import { useState } from "react"

export default function Index() {
  const [data, setData] = useState({
    name: "", 
    done: false
  });
  const [todos, setTodos] = useState([]);
  const [count, setCount] = useState(0);
  const [donecount, setDonecount] = useState(0);

  //add todo
  const addTodo = (e) => {
    e.preventDefault();
    setTodos([...todos, data])
    setData({name: "", done: false})
    setCount(todos.length + 1)
  };

  //set done
  const setDone = (e) => {
    let newTodos = []
    for (const item of todos) {
      if(item.name === e.name){
        item.done = ! item.done
        item.done ? setDonecount(donecount+1) : setDonecount(donecount-1)
      }
      // newTodos = [...newTodos, item]//like push method
      newTodos.push(item)
      setTodos(newTodos) 
    }
  }
  //delete
  const deleteTodo = (e) => {
    setTodos(todos.filter(item => item.name !== e.name))
    setCount(count-1)
    if(e.done === true){
      setDonecount(donecount-1)
    }
  }
  return (
    <>
      <h1 className="header">Todo {count} / {donecount}</h1>
      <div className="container col-4">
        <form onSubmit={addTodo} className="form">
          <div className="col-auto input-col">
            <input
              type="text"
              onChange={(e) => setData({name:e.target.value, done: false})}
              value={data.name}
              className="form-control input"
              placeholder="Enter todo item..."
            />
          </div>
          <div className="col-auto">
            <button type="submit" className="form-control">
              ADD
            </button>
          </div>
        </form>
        <ul>
          {todos.map(item => (
            <li key={item.name}>
              <span onClick={() => setDone(item)} className={item.done === true ? "done" : ""}>{item.name}</span>
              <button onClick={() => deleteTodo(item)} className="delete">X</button>
            </li>
          ))}
        </ul>
      </div>
    </>
  );
}
