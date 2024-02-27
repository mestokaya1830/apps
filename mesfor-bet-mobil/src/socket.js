import { io } from "socket.io-client"
// export const socket = io('https://www.mesfor.com',{
export const socket = io('http://localhost:4000',{
  transports: ["websocket"]//for cluster mode
})

// socket.on("connect", () => {
//   console.log('New user connected...')
// })

// socket.on("disconnect", () => {
//   console.log('User disconnected...')
// })