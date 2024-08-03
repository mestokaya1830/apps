// C++ code
//
#define led 2
void setup()
{
  pinMode(led, OUTPUT);
}

void loop()
{
  digitalWrite(led, 1);
  delay(1000); // Wait for 1000 millisecond(s)
  digitalWrite(led, 0);
  delay(1000); // Wait for 1000 millisecond(s)
}