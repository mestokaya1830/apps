import mongoose from "mongoose";

const ordersSC = new mongoose.Schema({
  userid: {
    type: String,
    required: [true, 'Userid is required!'],
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
  amount:{
    type: Number, 
    required:[true, 'Amount is required']
  },
  address:{
    type:Object, 
    required:[true, 'Address is required']
  },
  status:{
    type: Boolean, 
    required:[true, 'Status is required'],
    default: 'Pending'
  }
 
},{timestamps: true})


export default mongoose.model("orders", ordersSC)