#include <stdio.h>
#include <stdlib.h>

int main(void)
{
    unsigned int i = 1;
    char* p = (char*)&i;

    if(*p == 0)
    {
        printf("this is big endian. \n");
    }else if(*p == 1)
    {
        printf("this is little endian. \n");
    }else
    {
        printf("sorry, i do not know . \n");
    }
    return 0;
}
