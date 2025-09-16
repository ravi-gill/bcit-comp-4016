# bcit-comp-4016
## BCIT COMP 4106 - Applied DevOps with Kubernetes

### ASSIGNMENT 1

**Directory**
```
a1
```
**Image**
```
docker build -t prabhjotlalli/assignment1 .
```
**Container**
```
docker run -d -p 8080:8080 prabhjotlalli/assignment1
```
**cURL HTTP**
```
curl localhost:8080/foo
```
```
curl -H "Accept: application/json" -H "Content-Type: application/json" -X POST --data '{"name": "Prabh"}' localhost:8080/hello
```
```
curl localhost:8080/kill
```
**Note(s)**
```
- cURL HTTP responses are appended with '\n' - e.g., curl localhost:8080/foo will return "bar\n"
```

