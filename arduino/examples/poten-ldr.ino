// C++ code
//
#define red 9
#define blue 10
#define green 11
int poten = 0;

void setup()
{
  Serial.begin(9600);
  pinMode(red, OUTPUT);
  pinMode(blue, OUTPUT);
  pinMode(green, OUTPUT);
  pinMode(A0, INPUT);
}

void loop()
{
  poten  = map(analogRead(A0),0,1023,0,255);
  analogWrite(red, random(poten));
  analogWrite(blue, random(poten));
  analogWrite(green, random(poten));
  
  Serial.println(poten);
  delay(1000); // Wait for 10 millisecond(s)
}