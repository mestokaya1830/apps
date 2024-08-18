import mongoose from "mongoose";

const usersSC = new mongoose.Schema({
  username:{
    type: String,
    required: [true, 'Username is required!'],
    minlength: [3, 'Username must be grather then 2 charecters!'],
    maxlength: [255, 'Username must be less 255 charecters!']
  },
  email:{
    type: String,
    required: [true, 'Email is required!'],
    minlength: [3, 'Email must be grather then 2 charecters!'],
    maxlength: [255, 'Email must be less 255 charecters!']
  },
  password:{
    type: String,
    required: [true, 'Password is required!'],
    minlength: [3, 'Password must be grather then 2 charecters!'],
    maxlength: [255, 'Password must be less 255 charecters!']
  },
  isAdmin:{
    type: Boolean,
    default: false
  }
},{timestamps: true})


export default mongoose.model("users", usersSC)