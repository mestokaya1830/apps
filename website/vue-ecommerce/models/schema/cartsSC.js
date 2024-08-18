import mongoose from "mongoose";

const cartsSC = new mongoose.Schema({
  userID: {
    type: String,
    required: [true, 'UserID is required!'],
  },
  products:[
    {
      productdID:{
        type: String,
        required:[true, 'ProductID is required']
      },
      quantity:{
        type: Number,
        default: 1
      }
    }
  ],
 
},{timestamps: true})


export default mongoose.model("carts", cartsSC)