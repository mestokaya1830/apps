import mongoose from "mongoose";

const productsSC = new mongoose.Schema({
  title:{
    type: String,
    required: [true, 'Title is required!'],
    minlength: [3, 'Title must be grather then 2 charecters!'],
    maxlength: [255, 'Title must be less 255 charecters!'],
    unique: true
  },
  desc:{
    type: String,
    required: [true, 'Description is required!'],
    minlength: [10, 'Description must be grather then 2 charecters!'],
    maxlength: [500, 'Description must be less 500 charecters!']
  },
  categories:{
    type: Array,
  },
  img:{
    type: String,
    required: [true, 'Image is required!'],
    minlength: [3, 'Image must be grather then 2 charecters!'],
    maxlength: [255, 'Image must be less 255 charecters!']
  },
  size:{
    type: String,
    required: [true, 'Size is required!'],
    minlength: [3, 'Size must be grather then 2 charecters!'],
    maxlength: [20, 'Size must be less 20 charecters!']
  },
  color:{
    type: String,
    required: [true, 'Color is required!'],
    minlength: [3, 'Color must be grather then 2 charecters!'],
    maxlength: [20, 'Color must be less 20 charecters!']
  },
  price:{
    type: Number,
    required: [true, 'Price is required!']
  },
  
},{timestamps: true})


export default mongoose.model("products", productsSC)