// C++ code
//
#define led 2
#define btnOn 3
#define btnOff 4
void setup()
{
  Serial.begin(9600);
  pinMode(led, OUTPUT);
  pinMode(btnOn, INPUT);
  pinMode(btnOff, INPUT);
}

void loop()
{
  if(digitalRead(btnOn) == 1){
  	digitalWrite(led, 1);
  }
  if(digitalRead(btnOff) == 1){
  	digitalWrite(led, 0);
  }
  
  delay(10);
}