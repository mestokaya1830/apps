// C++ code
//
#define soil 4
#define red 2
void setup()
{
  Serial.begin(9600);
  pinMode(soil, INPUT);
  pinMode(red, OUTPUT);
}

void loop()
{
  if(digitalRead(soil) == 1){
  	digitalWrite(red, 1);
  } else {
    digitalWrite(red, 0);
  }
  
  Serial.println(digitalRead(soil));
  delay(10);
}