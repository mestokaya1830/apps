// C++ code
//
#define gas A0
#define red 2
void setup()
{
  Serial.begin(9600);
  pinMode(gas, INPUT);
  pinMode(red, OUTPUT);
}

void loop()
{
 
  if(analogRead(gas) > 200){
  	digitalWrite(red, 1);
  } else {
  	digitalWrite(red, 0);
  }
  Serial.println(analogRead(gas));
  delay(10);
}