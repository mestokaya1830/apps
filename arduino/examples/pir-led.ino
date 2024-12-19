// C++ code
//
#define pir 5
#define red 2
#define green 3
void setup()
{
  Serial.begin(9600);
  pinMode(pir, INPUT);
  pinMode(red, OUTPUT);
  pinMode(green, OUTPUT);
}

void loop()
{
  
  if(digitalRead(pir) == 1){
    digitalWrite(red, 1);
  	digitalWrite(green, 0);
  } else {
    digitalWrite(red, 0);
  	digitalWrite(green, 1);
  }
  
  Serial.println(digitalRead(pir));
  
  delay(10);
}