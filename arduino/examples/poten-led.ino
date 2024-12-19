// C++ code
//
#define led 3
int poten = 0;
void setup()
{
  Serial.begin(9600);
  pinMode(led, OUTPUT);
  pinMode(A0, INPUT);
}

void loop()
{
  poten = map(analogRead(A0), 0, 1023, 0, 255);
  analogWrite(led, poten);
  delay(10);
  Serial.println(poten);
}