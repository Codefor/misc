CC = gcc
#CFLAGS =  -D_GNU_SOURCE -Wall -O2
CFLAGS =  -g 

TARGET = multi

multi:bitmap.o test.c
	$(CC) -o multi $(CFLAGS) bitmap.o test.c

bitmap.o:bitmap.c bitmap.h
	$(CC) -c $(CFLAGS)  bitmap.c

clean:
	rm -rf multi *.o
