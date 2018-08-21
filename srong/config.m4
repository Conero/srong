dnl $Id$
dnl config.m4 for extension srong

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(srong, for srong support,
dnl Make sure that the comment is aligned:
dnl [  --with-srong             Include srong support])

dnl Otherwise use enable:

dnl PHP_ARG_ENABLE(srong, whether to enable srong support,
dnl Make sure that the comment is aligned:
dnl [  --enable-srong           Enable srong support])

if test "$PHP_SRONG" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-srong -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/srong.h"  # you most likely want to change this
  dnl if test -r $PHP_SRONG/$SEARCH_FOR; then # path given as parameter
  dnl   SRONG_DIR=$PHP_SRONG
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for srong files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       SRONG_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$SRONG_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the srong distribution])
  dnl fi

  dnl # --with-srong -> add include path
  dnl PHP_ADD_INCLUDE($SRONG_DIR/include)

  dnl # --with-srong -> check for lib and symbol presence
  dnl LIBNAME=srong # you may want to change this
  dnl LIBSYMBOL=srong # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $SRONG_DIR/$PHP_LIBDIR, SRONG_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_SRONGLIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong srong lib version or lib not found])
  dnl ],[
  dnl   -L$SRONG_DIR/$PHP_LIBDIR -lm
  dnl ])
  dnl
  dnl PHP_SUBST(SRONG_SHARED_LIBADD)

  PHP_NEW_EXTENSION(srong, srong.c, $ext_shared,, -DZEND_ENABLE_STATIC_TSRMLS_CACHE=1)
fi
